I18n国际化
-----------

### 翻译文件统一

将所有的翻译都映射到common/messages目录下，应用下自定义的标签写到对应的应用文字中，如frontend应用自定义标签写到common/messages/frontend.php中，使用Yii::t('frontend', 'Your Label');

其中常量放到cons.php文件中，如STATUS_ACTIVE

菜单权限翻译跟数据库中的字符有关，默认数据表中存储的是中文，所以以中文为原始语言翻译。

修改common/config/main.php

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
                        'app' => 'app.php', // 通用
                        'cons' => 'cons.php', // 常量，每个翻译目录都要有，否则常量名很难看
                        'permission' => 'permission.php', // 菜单，默认中文，其他语言目录需要有
                        'setting' => 'setting.php', // 设置，默认中文，其他语言目录需要有
                        'frontend' => 'frontend.php', // frontend自定义配置
                        'backend' => 'backend.php', // backend自定义配置
                        'api' => 'api.php', // api自定义配置
                    ],
                ],
            ],
        ],
    ],
```



### 前端Javascript的

在backend/resources/js/i18n/目录下有对应的i18n语言文件，添加标签和翻译后，直接使用fbT函数翻译即可

```
    fbT('Cpu/Memory Usage')
```

> 注意fbT函数定义在site.js中，需要将js放在最后，翻译文件修改后需要强制刷新浏览器CTRL+F5后才生效。

### 前台显示多语言代码

backend 默认代码如下

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

如果是前台

```
// 语言
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
    // 切换语言
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


