I18n国际化
-----------

### 后台

修改common/config/main.php

```php
    'language' => 'zh-CN',
    'sourceLanguage' => 'zh-cn',
```

都映射到common/messages目录下，应用下自定义的标签写到对应的应用文字中，如frontend应用自定义标签写到common/messages/frontend.php中，使用Yii::t('frontend', 'Your Labvel');


### 前端

在backend/resources/js/i18n/目录下有对应的i18n语言文件



