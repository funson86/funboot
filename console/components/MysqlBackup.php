<?php

namespace console\components;

use Yii;
use yii\db\Exception;
use yii\helpers\FileHelper;

/**
 *
 * 参考 https://github.com/yiier/yii2-backup/blob/master/helpers/MysqlBackup.php
 * Class MysqlBackup
 * @package console\components
 * @author funson86 <funson86@gmail.com>
 */
class MysqlBackup extends \yii\base\BaseObject
{
    public $menu = [];
    public $tables = [];
    public $fp;
    public $fileName;
    public $_path = '@runtime/runtime/backup/';
    public $backTempFile = 'db_backup_';

    public function __construct()
    {
        parent::__construct();

        $this->_path = Yii::getAlias(Yii::$app->params['dbBackupPath'] ?? '@console/runtime/backup/');

        if (!file_exists($this->_path)) {
            if (FileHelper::createDirectory($this->_path)) {
                chmod($this->_path, '777');
                return $this->_path;
            }
        }
    }

    public function execute()
    {
        $tables = $this->getTables();
        if (!$this->StartBackup()) {
            return false;
        }

        foreach ($tables as $tableName) {
            $this->getColumns($tableName);
        }

        foreach ($tables as $tableName) {
            $this->getData($tableName);
        }

        $sqlFile = $this->EndBackup();

        return $sqlFile;
    }

    public function execSqlFile($sqlFile)
    {
        $message = "ok";

        if (file_exists($sqlFile)) {
            $sqlArray = file_get_contents($sqlFile);

            $cmd = Yii::$app->db->createCommand($sqlArray);
            try {
                $cmd->execute();
            } catch (Exception $e) {
                $message = $e->getMessage();
            }

        }
        return $message;
    }

    public function getColumns($tableName)
    {
        $sql = 'SHOW CREATE TABLE ' . $tableName;
        $cmd = Yii::$app->db->createCommand($sql);
        $table = $cmd->queryOne();

        $create_query = $table['Create Table'] . ';';

        $create_query = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
        $create_query = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $create_query);
        if ($this->fp) {
            $this->writeComment('TABLE `' . addslashes($tableName) . '`');
            $final = 'DROP TABLE IF EXISTS `' . addslashes($tableName) . '`;' . PHP_EOL . $create_query . PHP_EOL . PHP_EOL;
            fwrite($this->fp, $final);
        } else {
            $this->tables[$tableName]['create'] = $create_query;
            return $create_query;
        }
    }

    public function getData($tableName)
    {
        $sql = 'SELECT * FROM ' . $tableName;
        $cmd = Yii::$app->db->createCommand($sql);
        $dataReader = $cmd->query();

        $data_string = '';

        foreach ($dataReader as $data) {
            $itemNames = array_keys($data);
            $itemNames = array_map("addslashes", $itemNames);
            $items = join('`,`', $itemNames);
            $itemValues = array_values($data);
            $itemValues = array_map("addslashes", $itemValues);
            $valueString = join("','", $itemValues);
            $valueString = "('" . $valueString . "'),";
            $values = "\n" . $valueString;
            if ($values != "") {
                $data_string .= "INSERT INTO `$tableName` (`$items`) VALUES" . rtrim($values, ",") . ";" . PHP_EOL;
            }
        }

        if ($data_string == '')
            return null;

        if ($this->fp) {
            $this->writeComment('TABLE DATA ' . $tableName);
            $final = $data_string . PHP_EOL . PHP_EOL . PHP_EOL;
            fwrite($this->fp, $final);
        } else {
            $this->tables[$tableName]['data'] = $data_string;
            return $data_string;
        }
    }

    /**
     * @param null $dbName
     * @return array|\yii\db\DataReader
     * @throws Exception
     */
    public function getTables($dbName = null)
    {
        $sql = 'SHOW TABLES';
        $cmd = Yii::$app->db->createCommand($sql);
        $tables = $cmd->queryColumn();
        return $tables;
    }

    public function StartBackup($addcheck = true)
    {
        $this->fileName = $this->_path . $this->backTempFile . date('YmdHis') . '.sql';

        $this->fp = fopen($this->fileName, 'w+');

        if ($this->fp == null)
            return false;
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        if ($addcheck) {
            fwrite($this->fp, 'SET AUTOCOMMIT=0;' . PHP_EOL);
            fwrite($this->fp, 'START TRANSACTION;' . PHP_EOL);
            fwrite($this->fp, 'SET SQL_QUOTE_SHOW_CREATE = 1;' . PHP_EOL);
        }
        fwrite($this->fp, 'SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;' . PHP_EOL);
        fwrite($this->fp, 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;' . PHP_EOL);
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        $this->writeComment('START BACKUP');
        return true;
    }

    public function EndBackup($addcheck = true)
    {
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        fwrite($this->fp, 'SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;' . PHP_EOL);
        fwrite($this->fp, 'SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;' . PHP_EOL);

        if ($addcheck) {
            fwrite($this->fp, 'COMMIT;' . PHP_EOL);
        }
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        $this->writeComment('END BACKUP');
        fclose($this->fp);
        $this->fp = null;
        return $this->fileName;
    }

    public function writeComment($string)
    {
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
        fwrite($this->fp, '-- ' . $string . PHP_EOL);
        fwrite($this->fp, '-- -------------------------------------------' . PHP_EOL);
    }
}