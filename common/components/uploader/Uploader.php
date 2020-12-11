<?php

namespace common\components\uploader;

use common\components\uploader\driver\DriverFactory;
use common\helpers\ArrayHelper;
use common\helpers\IdHelper;
use common\helpers\StringHelper;
use common\models\base\Attachment;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class Uploader
 * @package common\components\uploader
 * @author funson86 <funson86@gmail.com>
 */
class Uploader
{
    /**
     * 记录时间，防止隔天误差
     * @var int
     */
    public $now;

    /**
     * @var array
     */

    public $config = [];
    /**
     * @var \League\Flysystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    public $driver = 'local';

    /**
     * @var string
     */
    public $uploadType = 'image';

    /**
     * @var array
     */
    public $driverConfig = [];

    /**
     * 存储路径
     * @var array
     */
    public $paths = [];

    /**
     * @var string
     */
    public $rootPath = '@attachment';

    /**
     * 拿取需要的数据
     *
     * @var array
     */
    protected $filter = [
        'thumb',
        'driver',
        'chunks',
        'chunk',
        'guid',
        'image',
        'compress',
        'width',
        'height',
        'md5',
        'poster',
        'writeTable',
    ];

    /**
     * @var string
     */
    public $fileInfo = [
        'name' => '',
        'width' => '',
        'height' => '',
        'size' => 0,
        'md5' => '',
        'ext' => 'jpg',
        'url' => '',
        'merge' => false,
        'guid' => '',
        'file_type' => 'image/jpeg',
    ];

    public $uploadFileName = 'file';

    public function __construct($config, $uploadType, $append = false)
    {
        $this->now = time();
        $this->rootPath = Yii::$app->params['uploaderConfig']['rootPath'];

        $this->filter($config, $uploadType);
        $this->path();

        $driver = $this->driver;
        $this->filesystem = DriverFactory::$driver($this->driverConfig)->getFilesystem();
    }

    public function save()
    {
        $file = UploadedFile::getInstanceByName($this->uploadFileName);
        if (!$file) {
            throw new NotFoundHttpException('上传文件为空');
        }

        if ($file->getHasError()) {
            throw new NotFoundHttpException('上传失败，请检查文件');
        }

        $this->verify($file);

        $this->fileInfo['ext'] = strtolower($file->getExtension());
        $this->fileInfo['size'] = $file->size;
        $this->fileInfo['sizeLabel'] = Yii::$app->formatter->asShortSize($file->size);
        $this->fileInfo['file_type'] = $file->type;
        $this->fileInfo['name'] = $file->name;

        $this->fileInfo['path'] = $this->paths['relativeFile'] . '.' . $this->fileInfo['ext'];
        // local使用当前域名前缀
        $httpPrefix = $this->config['httpPrefix'];
        if ($this->driver == 'local') {
            $httpPrefix = Yii::$app->request->hostInfo . Yii::getAlias('@attachmentUrl') . '/';
        }
        $this->fileInfo['url'] = $httpPrefix . $this->paths['relativeFile'] . '.' . $this->fileInfo['ext'];

        $stream = fopen($file->tempName, 'r+');
        $result = $this->filesystem->writeStream($this->fileInfo['path'], $stream);

        if (!$result) {
            throw new NotFoundHttpException('文件写入失败');
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        if ($this->uploadType == Attachment::UPLOAD_TYPE_IMAGE) {
            $imgInfo = getimagesize(Yii::getAlias($this->rootPath) . '/' . $this->fileInfo['path']);
            $this->fileInfo['width'] = $imgInfo[0] ?? 0;
            $this->fileInfo['height'] = $imgInfo[1] ?? 0;
        }

        // 存入数据库
        $model = Attachment::create($this->fileInfo);
        return array_merge($this->fileInfo, $model->attributes);
    }

    /**
     * @param UploadedFile $file
     * @throws NotFoundHttpException
     */
    protected function verify($file)
    {
        if ($file->size > $this->config['maxSize']) {
            throw new NotFoundHttpException('文件大小超出网站限制');
        }

        if (!empty($this->config['ext']) && !in_array($file->getExtension(), $this->config['ext'])) {
            throw new NotFoundHttpException('文件类型不允许');
        }

        // 存储本地进行安全校验
        if ($this->driver == 'local') {
            if ($this->uploadType == Attachment::UPLOAD_TYPE_FILE
                && in_array(strtolower($file->getExtension()), $this->config['blacklist'])) {
                throw new NotFoundHttpException('上传的文件类型不允许');
            }
        }

    }

    protected function path()
    {
        $config = $this->config;
        $fileName = $config['prefix'] . date('ymd') . '_' . IdHelper::snowFlakeId();
        $filePath = $config['path'] . date($config['subName'], $this->now) . '/';
        $this->paths['relativePath'] = $filePath;
        $this->paths['relativeFile'] = $filePath . $fileName;

        if ($this->uploadType = Attachment::UPLOAD_TYPE_IMAGE) {
            //$this->uploadType
        }
    }

    protected function filter($config, $uploadType)
    {
        try {
            // 解密json
            foreach ($config as $key => &$item) {
                if (!empty($item) && !is_numeric($item) && !is_array($item)) {
                    !empty(json_decode($item)) && $item = Json::decode($item);
                }
            }

            $config = ArrayHelper::filter($config, $this->filter);
            $this->config = ArrayHelper::merge(Yii::$app->params['uploaderConfig'][$uploadType], $config);
            $this->driver = $this->config['driver'];

            $this->fileInfo = $this->config;
            $this->fileInfo['upload_type'] = $uploadType;
            $this->fileInfo['year'] = date('Y');
            $this->fileInfo['month'] = date('m');
            $this->fileInfo['day'] = date('d');
            $this->fileInfo['ip'] = Yii::$app->request->getRemoteIP();

            // 参数
            $this->fileInfo['width'] = $this->config['width'] ?? 0;
            $this->fileInfo['height'] = $this->config['height'] ?? 0;
        } catch (\Exception $e) {
            $this->config = Yii::$app->params['uploaderConfig'][$uploadType];
        }

        !empty($this->config['drive']) && $this->drive = $this->config['drive'];

    }
}