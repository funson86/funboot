BaseModel & XxxBase
-----------

目录
- BaseModel
- XxxBase
- Model


> 为了实现定义一些公共的字段和方法，在model中插入BaseModel这一层级

> 为了实现多语言和字段修改可以再次gii生成代码，在model中插入了XxxBase这一层级。

> 为了支持注释语言作为标签同时支持i18n用英语作为翻译,优化了生成的Model


### BaseModel

在Yii2生成的Model默认继承yii\db\ActiveRecord，Funboot在中间首先定义了common\models\BaseModel，后续生成Model和XxxBase继承BaseModel

BaseModel定义了一些status和type两个字段的常量和标签，子类可以参考这种方式进行。

还定义了行为，默认自动更新store_id，对于数据变更记录到日志表中，参见[Funboot日志组件](dev-log.md)


### XxxBase

在Funboot的Gii中会有生成XxxBase类，在原本的Model中又加入了一层XxxBase，可以将自定义的常量、标签和一些自定义的方法写到该类中，这样字段变更的时候，只需要重新Gii生成Model文件直接覆盖。

具体可以参考common/base/LogBase等文件中定义的常量和方法

### Model

Model支持Funboot Gii无限次的覆盖，因为自定义代码都写到XxxBase中

在数据表sql中加入注释，会自动生成为字段标签

系统有指定注释的语言版本，可以使用任意语言作为注释语言快速生成代码，同时支持使用英语作为i18n其他翻译的基础语言。

配置位于common/config/params.php中

```php
    'sqlCommentLanguage' => 'zh-CN', //sql的字段注释语言
```


