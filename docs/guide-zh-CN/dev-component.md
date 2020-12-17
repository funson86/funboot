系统组件
-----------

### logSystem 日志组件 


### settingSystem 配置组件

每个Store的配置ID是不同的，需要传入code和storeId

```php
Yii::$app->settingSystem->getValue('website_copyright', 1);


```


### dictSystem 数据字典组件 

数据字典主要用来给运营人员使用的，比如已系统开通的城市，在数据字典中添加代码即可

```php
Yii::$app->dictSystem->getDict('button_type');
Yii::$app->dictSystem->getDictData('button_type_edit');
```