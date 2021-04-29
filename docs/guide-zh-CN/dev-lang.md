多语言 & 自动翻译
-----------

Funboot将多语言数据存储在fb_base_lang表中，通过对每个需要加多语言的表进行编号，放在一个表中也有利于数据自动翻译。

开启自动翻译默认会将源语言翻译成指定的多国语音，默认使用百度翻译，需要修改翻译方式覆盖autoTranslate函数即可。

### Model部分

指定tableCode，必须整个项目唯一，建议与fb_base_permission中的ID前缀保持一致

```php
    static $tableCode = 5001;

    static $mapLangFieldType = [
        'name' => 'text',
        'brief' => 'textarea',
        'content' => 'Ueditor',
    ];
```

### 控制器

指定$isMultiLang为真

```php
    public $isMultiLang = true;
```


### 添加view

在view的edit.php中加入如下代码，支持text、textarea、Ueditor、markdown格式，需要支持其他格式实现这一段代码即可

```
                    <?php if ($this->context->isMultiLang) { ?>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-3" data-toggle="pill" href="#tab-content-lang"><?= Yii::t('app', 'Multi Language') ?></a>
                    </li>
                    <?php } ?>

                    <?php if ($this->context->isMultiLang) { ?>
                    <div class="tab-pane fade" id="tab-content-lang">
                        <div class="row">
                            <div class="col-2 col-sm-2">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                    <?php $i = 0; foreach ($lang as $field => $item) { ?>
                                    <a class="nav-link <?= $i == 0 ? 'active' : '' ?>" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-<?= $field ?>" role="tab" aria-controls="vert-tabs-home" aria-selected="true"><?= $model->getAttributeLabel($field) ?></a>
                                    <?php $i++; } ?>
                                </div>
                            </div>
                            <div class="col-10 col-sm-10">
                                <div class="tab-content" id="vert-tabs-tabContent">
                                    <?php $i = 0; foreach ($lang as $field => $item) { ?>
                                    <div class="tab-pane <?= $i == 0 ? 'active' : 'fade' ?>" id="vert-tabs-<?= $field ?>" role="tabpanel" aria-labelledby="vert-tabs-<?= $field ?>-tab">
                                        <?php foreach ($item as $language => $v) { ?>
                                            <div class="form-group row field-catalog-redirect_url has-success">
                                                <label class="control-label control-label-full"><?= Lang::getLanguageLabels(intval(Lang::getLanguageCode($language, false, true))) ?></label>
                                                <?php
                                                    if (ActiveModel::getLangFieldType($field) == 'textarea') {
                                                        echo Html::textarea("Lang[$field][$language]", $v, ['class' => 'form-control', 'rows' => 6]);
                                                    } elseif (ActiveModel::getLangFieldType($field) == 'Ueditor') {
                                                        echo \common\components\ueditor\Ueditor::widget([
                                                            'id' => 'Ueditor-' . $field . '-' . $language,
                                                            'attribute' => $field,
                                                            'name' => 'Lang[' . $field . '][' . $language . ']',
                                                            'value' => $v,
                                                            'formData' => [
                                                                'drive' => 'local',
                                                                'writeTable' => false, // 不写表
                                                            ],
                                                            'config' => [
                                                                'toolbars' => [
                                                                    [
                                                                        'fullscreen', 'source', 'undo', 'redo', '|',
                                                                        'customstyle', 'paragraph', 'fontfamily', 'fontsize'
                                                                    ],
                                                                    [
                                                                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat',
                                                                        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                                                                        'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                                                                        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                                                                        'directionalityltr', 'directionalityrtl', 'indent', '|'
                                                                    ],
                                                                    [
                                                                        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                                                                        'link', 'unlink', '|','simpleupload',
                                                                        'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'insertcode', 'pagebreak', '|',
                                                                        'horizontal', 'inserttable', '|',
                                                                        'print', 'preview', 'searchreplace', 'help'
                                                                    ]
                                                                ],
                                                            ]
                                                        ]) ;
                                                    } elseif (ActiveModel::getLangFieldType($field) == 'markdown') {
                                                        echo \common\widgets\markdown\Markdown::widget([
                                                            'id' => 'markdown-' . $field . '-' . $language,
                                                            'attribute' => $field,
                                                            'name' => 'Lang[' . $field . '][' . $language . ']',
                                                            'value' => $v,
                                                            'options' => [
                                                                'width' => "100%",
                                                                'height' => 500,
                                                                'emoji' => false,
                                                                'taskList' => true,
                                                                'flowChart' => true, // 流程图
                                                                'sequenceDiagram' => true, // 序列图
                                                                'tex' => true, // 科学公式
                                                                'imageUpload' => true,
                                                                'imageUploadURL' => Url::toRoute([
                                                                    '/file/image-markdown',
                                                                    'driver' => Yii::$app->params['uploaderConfig']['image']['driver'],
                                                                ]),
                                                            ]
                                                        ]) ;
                                                    } else {
                                                        echo Html::textInput("Lang[$field][$language]", $v, ['class' => 'form-control']);
                                                    }

                                                ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php $i++; } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
```

### 自动翻译

在common/config/params-local.php文件中增加百度翻译的key，请到https://fanyi-api.baidu.com/ 注册并获取key。

```
    'baiduTranslate' => [
        'appId' => 'xxx',
        'appSecret' => 'xxxx',
        'url' => 'http://api.fanyi.baidu.com/api/trans/vip/translate',
    ],
```