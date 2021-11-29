I18n Internationalization
-----------

### Unite Language file

All language file are mapping to common/messages, 应用下自定义的标签写到对应的应用文字中，如frontend应用自定义标签写到common/messages/frontend.php中，使用Yii::t('frontend', 'Your Label');

Constant label in cons.php, eg: STATUS_ACTIVE

Permission translation is related to database table field comment. default is chinese, so the translation left label is chinese.

modify the common/config/main.php

```php
    'language' => 'zh-CN',
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php', // common
                        'cons' => 'cons.php', // constant, need in every language directory
                        'permission' => 'permission.php', // permission, default chinese, need in every language directory except zh-CN
                        'setting' => 'setting.php', // setting, default chinese, need in every language directory except zh-CN
                        'frontend' => 'frontend.php', // frontend translation
                        'backend' => 'backend.php', // backend translation
                        'api' => 'api.php', // api translation
                    ],
                ],
            ],
        ],
    ],
```



### Multiple Language in Javascript

All i18n file in backend/resources/js/i18n/ directory, after add label and translation use fbT function to translate.

```
    fbT('Cpu/Memory Usage')
```

> Note the fbT defined in site.js, you should add the js in the end, force-refresh(CTRL+F5) in the browser after modify the language file.

### Show multiple language selection

backend code show below

```
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="flag-icon flag-icon-<?= Lang::getLanguageFlag(Lang::getLanguageCode(Yii::$app->language, true, true)) ?>"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <?php foreach (Lang::getLanguageCode() as $id => $label) { if (($store->language & $id) == $id) {?>
                <a href="javascript:;" class="dropdown-item funboot-lang" data-lang="<?= $label ?>">
                    <i class="flag-icon flag-icon-<?= Lang::getLanguageFlag($id) ?> mr-2"></i> <?= Lang::getLanguageLabels($id) ?>
                </a>
                <?php } } ?>
            </div>
        </li>
```

In frontend

```
// language
$languages = [];
foreach (Lang::getLanguageCode() as $id => $label) {
    if (($store->lang_frontend & $id) == $id) {
        $languages[] = ['label' => '<i class="flag-icon flag-icon-' . Lang::getLanguageFlag($id) . ' mr-2"></i>' . Lang::getLanguageLabels($id), 'url' => 'javascript:;', 'linkOptions' => ['class' => 'funboot-lang', 'data-lang' => $label]];
    }
}
$menuItems[] = [
    'label' => Html::tag('i', '', ['class' => 'flag-icon flag-icon-' . Lang::getLanguageFlag(Lang::getLanguageCode(Yii::$app->language, true, true))]),
    'items' => $languages,
];

```

```js
<script>
    // switch language
    $('.funboot-lang').click(function() {
        let lang = $(this).data('lang')
        let param = {
            lang: lang
        }
        $.get("<?= Url::to(['/site/set-language']) ?>", param, function(data) {
            if (parseInt(data.code) === 200) {
                window.location.reload();
            }
        })
    });
</script>
```


