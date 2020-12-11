<?php

namespace common\helpers;

use Yii;
use Exception;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;

/**
 * Class OfficeHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class OfficeHelper
{
    /*
     * 这种方式导出的csv文件是utf8格式，直接用excel打开会乱码
     */
    public static function write(Spreadsheet $spreadsheet, $ext, $fileName = null, $path = null, $csvGbk = true)
    {
        // 清除之前的输出
        ob_end_clean();
        ob_start();

        $writer = $header = null;
        switch ($ext) {
            case 'csv':
                if (!$csvGbk) {
                    $writer = new Csv($spreadsheet);
                    if ($path) {
                        $writer->save($path);
                    }
                    if ($fileName) {
                        header("Content-type:text/csv;");
                        header("Content-Disposition:inline;filename=" . $fileName);
                        header('Cache-Control: max-age=0');
                        $writer->save('php://output');

                        ob_end_flush();
                        exit();
                    }
                } else {
                    $content = self::csvUtf8ToGbk($spreadsheet);
                    if ($path) {
                        file_put_contents($path, $content);
                    }
                    if ($fileName) {
                        header("Content-type:text/csv;");
                        header("Content-Disposition:inline;filename=" . $fileName);
                        header('Cache-Control: max-age=0');
                        echo $content;

                        ob_end_flush();
                        exit();
                    }
                }
                return true;
            case 'xls':
                $writer = new Xls($spreadsheet);
                $header = "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8;";
                break;
            case 'xlsx':
                $writer = new Xlsx($spreadsheet);
                $header = "Content-Type:application/vnd.ms-excel;charset=utf-8;";
                break;
            case 'html':
                $writer = new Html($spreadsheet);
                $header = "Content-Type:text/html;charset=utf-8;";
                break;
            default:
                return false;
        }

        if ($path && $writer) {
            $writer->save($path);
        }

        if ($fileName && $writer && $header) {
            // 清除之前的输出
            ob_end_clean();
            ob_start();

            header($header);
            header("Content-Disposition:inline;filename=" . $fileName);
            header('Cache-Control: max-age=0');
            $writer->save('php://output');

            ob_end_flush();
            exit();
        }

        return true;
    }

    /**
     * 读取excel数据
     * @param $filePath
     * @param int $startRow
     * @param bool $sheetMulti
     * @return array|mixed
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function readExcel($filePath, $startRow = 1, $sheetMulti = false)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        if (!$reader->canRead($filePath)) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            // setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
            $reader->setReadDataOnly(true);

            if (!$reader->canRead($filePath)) {
                throw new Exception(Yii::t('app', 'Can not read excel'));
            }
        }

        $spreadsheet = $reader->load($filePath);
        $sheetCount = $spreadsheet->getSheetCount();// 获取sheet的数量
        // 获取所有的sheet表格数据
        $excelCells = [];
        $emptyRowNum = 0;
        for ($i = 0; $i < $sheetCount; $i++) {
            $currentSheet = $spreadsheet->getSheet($i); // 读取excel文件中的第一个工作表
            $allColumn = $currentSheet->getHighestColumn(); // 取得最大的列号
            $allColumn = Coordinate::columnIndexFromString($allColumn); // 由列名转为列数('AB'->28)
            $allRow = $currentSheet->getHighestRow(); // 取得一共有多少行

            $arr = [];
            for ($currentRow = $startRow; $currentRow <= $allRow; $currentRow++) {
                // 从第1列开始输出
                for ($currentColumn = 1; $currentColumn <= $allColumn; $currentColumn++) {
                    $val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
                    $arr[$currentRow][] = trim($val);
                }

                // 统计连续空行
                if (empty($arr[$currentRow]) && $emptyRowNum <= 50) {
                    $emptyRowNum++;
                } else {
                    $emptyRowNum = 0;
                }
                // 防止坑队友的同事在excel里面弄出很多的空行，陷入很漫长的循环中，设置如果连续超过50个空行就退出循环，返回结果
                // 连续50行数据为空，不再读取后面行的数据，防止读满内存
                if ($emptyRowNum > 50) {
                    break;
                }
            }

            $excelCells[$i] = $arr; // 多个sheet的数组的集合
        }

        foreach ($excelCells as &$item) {
            $item = array_filter($item);
        }

        // 根据情况返回一个还是多个sheet
        return $sheetMulti ? $excelCells : array_shift($excelCells);
    }

    /*
     * @param
     */
    public static function utf8ToGbk($str)
    {
        return mb_convert_encoding($str, 'gbk', 'utf-8');
    }

    public static function gbkToUtf8($str)
    {
        return mb_convert_encoding($str, 'utf-8', 'gbk');
    }

    public static function csvUtf8ToGbk(Spreadsheet $spreadsheet)
    {
        $content = '';
        $sheet = $spreadsheet->getActiveSheet();
        $allColumn = Coordinate::columnIndexFromString($sheet->getHighestColumn()); // 取得最大的列号并由列名转为列数('AB'->28)
        $allRow = $sheet->getHighestRow(); // 取得行数

        for ($i = 1; $i <= $allRow; $i++) {
            $line = null;
            for ($j = 1; $j <= $allColumn; $j++) {
                $value = self::utf8ToGbk($sheet->getCellByColumnAndRow($j, $i)->getValue());
                if (!$line) {
                    $line = '"' . $value . '"';
                } else {
                    $line .= ',"' . $value . '"';
                }
            }
            $content .= $line . "\n";
        }

        return $content;
    }
}