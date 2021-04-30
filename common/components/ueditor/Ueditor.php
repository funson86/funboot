<?php

namespace common\components\ueditor;

use common\components\ueditor\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\ArrayHelper;
use Yii;
use yii\helpers\Json;

/**
 * Class Ueditor
 * @package common\components\ueditor
 * @author funson86 <funson86@gmail.com>
 */
class Ueditor extends \yii\widgets\InputWidget
{
    public $style = 1;

    public $config = [];

    public $formData = [];

    public function init()
    {
        parent::init();
        $this->value = $this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute) : $this->value;
        $this->name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name;

        $asset = AppAsset::register($this->view);
        //常用配置项
        $config = [
            'serverUrl' => Url::to(['/ueditor/index']),
            'searchUrl' => Url::to(['/file/index']),
            'UEDITOR_HOME_URL' => $asset->baseUrl . '/',
            'lang' => 'zh-cn',
            'initialFrameHeight' => 400,
            'initialFrameWidth' => '100%',
            'enableAutoSave' => false,
            'toolbars' => [
                [
                    'fullscreen', 'source', 'undo', 'redo', '|',
                    'customstyle', 'paragraph', 'fontfamily', 'fontsize'
                ],
                [
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript',
                    'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                    'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|'
                ],
                [
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                    'link', 'unlink', '|',
                    'simpleupload', $this->style == 1 ? 'insertimage' : '', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'insertcode', 'pagebreak', '|',
                    'horizontal', 'inserttable', '|',
                    'print', 'preview', 'searchreplace', 'help'
                ]
            ],
        ];

        if (!empty($this->config['toolbars'])) {
            unset($config['toolbars']);
        }
        $this->config = ArrayHelper::merge($config, $this->config);
        $this->formData = ArrayHelper::merge([
            'driver' => Yii::$app->params['UEditorUploadDriver'],
        ], $this->formData);

    }

    public function run()
    {
        $this->registerClientScript();

        $id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, ['id' => $id]);
        }

        return Html::textarea(ArrayHelper::getValue($this->config, 'textarea', $this->name), $this->value, ['id' => $id]);
    }

    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        $id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        $jsonConfig = Json::encode($this->config);

        //  由于百度上传不能传递数组，所以转码成为json
        !isset($this->formData) && $this->formData = [];
        foreach ($this->formData as &$item) {
            if (!empty($item) && is_array($item)) {
                $item = Json::encode($item);
            }
        }

        $jsonFormData = Json::encode($this->formData);

        // ready部分代码，是为了缩略图管理。UEditor本身就很大，在后台直接加载大文件图片会很卡。
        $script = <<<JS
        UE.delEditor('{$id}');
        var ue = UE.getEditor('{$id}',{$jsonConfig}).ready(function(){
            this.addListener( "beforeInsertImage", function ( type, imgObjs ) {
                for(var i=0;i < imgObjs.length;i++){
                    imgObjs[i].src = imgObjs[i].src.replace(".thumbnail","");
                }
            });
            
            this.execCommand('serverparam', function(editor) {
                return {$jsonFormData};
            });
        });
        
        $('.UEditorTemplate').click(function () {
            var content = $(this).data('content');
            content = content.toString();
            
            if (content.length === 0) {
                return;
            }
            
            UE.getEditor('{$id}').focus();
            UE.getEditor('{$id}').execCommand('inserthtml', content);
        });
JS;

        $this->getView()->registerJs($script);
    }
}
