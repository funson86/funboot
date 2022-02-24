<?php

namespace common\components\uploader;

use common\components\uploader\assets\AppAsset;
use common\helpers\ArrayHelper;
use common\helpers\IdHelper;
use common\helpers\Url;
use common\models\base\Attachment;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use Yii;

/**
 * Class FileWidget
 * @package common\components\uploader
 * @author funson86 <funson86@gmail.com>
 */
class FileWidget extends InputWidget
{
    public $boxId;

    public $config = [];

    public $typeConfig = [];

    public $theme = 'default';

    public $themeConfig = [];

    /**
     * @var string the input name. This must be set if [[model]] and [[attribute]] are not set.
     */
    public $name;
    /**
     * @var string the input value.
     */
    public $value;

    public $uploadType = Attachment::UPLOAD_TYPE_IMAGE;

    // ajax upload-box-immediately 监听和 funboot.widget.js中的冲突，
    public $ajax = false;

    public function init()
    {
        parent::init();

        $this->themeConfig = ArrayHelper::merge([
            'select' => true, // 显示选择文件
            'sortable' => true, // 是否开启排序
        ], $this->themeConfig);

        $this->typeConfig = Yii::$app->params['uploaderConfig'][$this->uploadType];

        $this->boxId = IdHelper::snowFlakeId();
        $this->config = ArrayHelper::merge([
            'compress' => false, // 压缩
            'auto' => false, // 自动上传
            'formData' => [
                'guid' => null,
                'md5' => null,
                'writeDb' => true,
                'driver' => $this->typeConfig['driver'], // 默认本地 可修改 qiniu/oss/cos 上传
            ], // 表单参数
            'pick' => [
                'id' => '.upload-album-' . $this->boxId,
                'innerHTML' => '', // 指定按钮文字。不指定时优先从指定的容器中看是否自带文字。
                'multiple' => '', // 是否开起同时选择多个文件能力
            ],
            'accept' => [
                'title' => 'Images',// 文字描述
                //'extensions' => implode(',', $this->typeConfig['extensions']), // 后缀
                //'mimeTypes' => $this->typeConfig['mimeTypes'],// 上传文件类型
            ],
            'swf' => null, //
            'chunked' => false,// 开启分片上传
            'chunkSize' => 10 * 1024 * 1024,// 分片大小
            'server' => Url::to(['/file/' . $this->uploadType]), // 默认上传地址
            'fileVal' => 'file', // 设置文件上传域的name
            'disableGlobalDnd' => true, // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
            'fileNumLimit' => 20, // 验证文件总数量, 超出则不允许加入队列
            'fileSizeLimit' => null, // 验证文件总大小是否超出限制, 超出则不允许加入队列 KB
            //'fileSingleSizeLimit' => $this->typeConfig['maxSize'], // 验证单个文件大小是否超出限制, 超出则不允许加入队列 KB
            'prepareNextFile' => true,
            'duplicate' => true,

            /**-------------- 自定义的参数 ----------------**/
            'independentUrl' => false, // 独立上传地址,不受全局的地址上传影响
            'md5Verify' => $this->typeConfig['md5Verify'], // md5 校验
            'verifyMd5Url' => Url::to(['/file/verify-md5']),
            'mergeUrl' => Url::to(['/file/merge']),
            'getOssPathUrl' => Url::to(['/file/get-oss-path']),
            'callback' => null, // 上传成功回调js方法
            'callbackProgress' => null, // 上传进度回调
            'name' => $this->name,
            'boxId' => $this->boxId,
        ], $this->config);

        $view = $this->getView();
        AppAsset::register($view);
    }

    public function run()
    {

        $value = $this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute) : $this->value;
        $name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name;

        empty($value) && $value = [];
        if ($this->config['pick']['multiple'] == true) {
            // 赋予默认值
            $name = $name . '[]';

            try {
                if ($value && !is_array($value)) {
                    $value = json_decode($value, true);
                    empty($value) && $value = unserialize($value);
                    empty($value) && $value = [];
                }
            } catch (\Exception $e) {
                $value = [];
            }
        }

        if (!is_array($value)) {
            $tmp = $value;
            $value = [];
            $value[] = $tmp;
        }

        // 由于百度上传不能传递数组，所以转码成为json
        !isset($this->config['formData']) && $this->config['formData'] = [];

        foreach ($this->config['formData'] as &$item) {
            if (!empty($item) && is_array($item)) {
                $item = Json::encode($item);
            }
        }

        $this->registerClientScript();

        return $this->render($this->theme, [
            'name' => $name,
            'value' => $value,
            'boxId' => $this->boxId,
            'uploadType' => $this->uploadType,
            'config' => $this->config,
            'themeConfig' => $this->themeConfig,
            'ajax' => $this->ajax,
        ]);

    }
    /**
     * 注册资源
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        AppAsset::register($view);
        $boxId = $this->boxId;
        $jsConfig = Json::encode($this->config);
        $disabled = $this->themeConfig['sortable'] ?? true;

        $view->registerJs(
<<<Js
$(".upload-album-{$boxId}").InitUploader({$jsConfig});
// 兼容老IE
document.body.ondrop = function (event) {
    event = event || window.event;
    if (event.preventDefault) {
        event.preventDefault();
        event.stopPropagation();
    } else {
        event.returnValue = false;
        event.cancelBubble = true;
    }
};
Js
        );
    }
}