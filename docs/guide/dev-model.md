BaseModel & XxxBase
-----------

Table of contents
- BaseModel
- XxxBase
- Model


> In order to define some common fields and methods, add a layer of BaseModel

> For multiple language and model re-generation after table field modification, and the layer of xxxBase is inserted between model and BaseModel.

> Support to use the database table field comment as field label, and support i18n translation in Model.


### BaseModel

Model inherit yii\db\ActiveRecord in Yii by default，Funboot defines common\models\BaseModel，The generated Model and XxxBase inherit BaseModel

BaseModel defined some common constant and label, eg: status and type, you can define your constant referring to the code.

Base Model will assign store_id to current store id, and add log while table data modification, refer to [Funboot Log Component](dev-log.md)


### XxxBase

Funboot Gii genente XxxBase class, A layer of XxxBase is added to the original model, which can write custom constants, labels and some custom methods into this class. In this way, when the table fields change, you only need to regenerate the Gii model file and directly overwrite it.

For details, refer to constants and methods defined in common/base/LogBase file

### Model

Funboot Gii support re-genrate Model after table field modified, for the code related to model is added in XxxBase

If you add comments to the data table SQL, they will be automatically generated as field labels

The system has the language of the specified annotation, and can use any language as the annotation language to quickly generate code. At the same time, it supports the use of English as i18n other basic languages for translation.

Config is in common/config/params.php

```php
    'sqlCommentLanguage' => 'zh-CN', //sql comment language code
```


