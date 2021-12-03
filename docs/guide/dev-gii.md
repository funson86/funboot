Gii
-------

Table of contents

- Gii Config
- model
- Re-generate model after table field modified
- crud
- module

### Gii Config

Add funboot gii template in backend/config/main-local

```php
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => \common\components\gii\crud\Generator::className(),
                'templates' => [
                    'funboot' => '@common/components/gii/crud/default',
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/crud/default',
                ]
            ],
            'model' => [
                'class' => \common\components\gii\model\Generator::className(),
                'templates' => [
                    'funboot' => '@common/components/gii/model/default',
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/crud/default',
                ]
            ]
        ],
    ];
```

### model
``` 
Table Name: fb_school_student
Model Class Name: Student
Namespace: common\models\school
Base Class: common\models\BaseModel
Select Use Table Prefix
Not select Generate Labels from DB Comments // If the English is required, the attributelabels() method in the model should be removed
Select Generate Relations from Current Schema
Select Enable I18N
```
![](images/gii-model-03.png)
![](images/gii-model-05.png)


### Re-generate model after table field modified

- During development, the database foreign key shall be defined in the data table to generate the relationship. The online database deletes the foreign key relationship to improve the performance.
- When generating foreign keys, the relevant codes of foreign keys move to ModelBase, including rules and getRelation functions
- Generate Relations select No relation at last.

- Or select no relation generate model, then select All relations to preview relation code and copy to ModelBase.


### crud
```
Model Class: common\models\school\Student
Controller Class: backend\modules\school\controllers\StudentController
View Path: @backend/modules/school/views/student
Base Controller Class: backend\controllers\BaseController
勾选 Enable I18N
勾选 Code Template: funboot
```

![](images/gii-crud-03.png)
![](images/gii-crud-05.png)

### module
``` 
Module Class: backend\modules\school\Module
Module ID: school
DefaultController Base Class: backend\controllers\BaseController
Code Template: funboot
```

![](images/gii-module-03.png)

api
![](images/gii-module-05.png)
