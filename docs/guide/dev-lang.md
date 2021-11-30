I18n & Auto translation
-----------

Funboot save all language translation in fb_base_lang table, and complete auto-translate to this table。

Enable Auto Translation in the  backend will translate source language to specified language, use Baidu Translator by default. If use other translator need to modify autoTranslate function.

### Model

Specify tableCode, must be unique in project, you can use fb_base_permission ID for project table code

```php
    static $tableCode = 5001;

    static $mapLangFieldType = [
        'name' => 'text',
        'brief' => 'textarea',
        'content' => 'Ueditor',
    ];
```

### Controller

Edit $isMultiLang as true

```php
    public $isMultiLang = true;
```


### View file

Add code below to edit.php in view directory, support text、textarea、Ueditor、markdown, other format need to change code here.

```
                    <?php if ($this->context->isMultiLang) { ?>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-3" data-toggle="pill" href="#tab-content-lang"><?= Yii::t('app', 'Multi Language') ?></a>
                    </li>
                    <?php } ?>

                    <?php if ($this->context->isMultiLang) { ?>
                    <div class="tab-pane fade" id="tab-content-lang">
                        <?= $form->field($model, 'translating')->radioList(YesNo::getLabels())->hint(Yii::t('app', 'Auto translating while selecting yes and field is empty'), ['class' => 'ml-3']) ?>
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

### Frontend

In controller

```php
fbt(Catalog::getTableCode(), $model->id, 'name', $model->name);

// or use this function
$this->getLang(Catalog::getTableCode(), $model->id, 'name', $model->name, Yii::$app->language);
```

In view

```php
fbt(Catalog::getTableCode(), $model->id, 'name', $model->name, Yii::$app->language);

// or use this function
$this->context->getLang(Catalog::getTableCode(), $model->id, 'name', $model->name, Yii::$app->language);
```


### Auto translation

Add Baidu Translator key in common/config/params-local.php file, you can apply in https://fanyi-api.baidu.com/ adn get key

```
    'baiduTranslate' => [
        'appId' => 'xxx',
        'appSecret' => 'xxxx',
        'url' => 'http://api.fanyi.baidu.com/api/trans/vip/translate',
    ],
```