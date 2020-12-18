二次开发
-------

Funboot框架可以在定义数据表之后，通过[Funboot的Gii](gii.md)生成一个功能齐全的精美页面。

### 目录结构

- backend/controllers 有BaseController和SiteController，后端所有的类都要继承BaseController, 登录注册相关在SiteController中
- modules/base/controller 基本功能类在这个模块目录下
- modules/your/controller 自定义模块，可以用[Gii](gii.md)生成

如果是开发小型项目可以直接写在backend/controllers中，如果是大型项目则使用

- /common/components 组件目录，集成到代码中，可以提供Controller直接访问
- /common/helpers 公共方法目录，函数都是static，helper一般不与数据库交互
- /common/services 服务，一般有缓存或者队列操作，需要在启动时加载一些数据
- /common/widgets 可重用的小部件，一般会渲染html嵌入到其他代码中，一般不提供Controller访问

### sql表设计

- 便于方便，int统一使用int(11), varchar使用255/32/64/128/1022长度，一般无特别之处用255，时间统一用int(11);
- id统一使用int(11)，也便于添加删除外键，关联其他表的外键id一般使用 表_id方式，如关联user表，则命名为user_id，批量替换时候也可以根据 _id` 批量替换类型。
- 如果项目分布式，可以使用雪花算法，修改数据表id为varchar(255) NOT NULL，修改model文件和BaseController中的findModel中new之后添加字符串$model->id;
- 框架默认的使用如下表结构，建议在此表结构上添加自定义的字段、索引和外键。推荐开发阶段和测试环境添加外键，线上环境去掉外键。
- 数据表增加COMMENT描述，使用[Funboot的Gii](gii.md)会在Model文件中生成中英双语标签，无需编写众多的i18n翻译文件。

```sql
DROP TABLE IF EXISTS `fb_template`;
CREATE TABLE `fb_template` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `school_student_fk2` (`store_id`),
  CONSTRAINT `pay_payment_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '模板';
```



### Model
Models分成Model和ModelBase两个文件。
- 使用[Funboot的Gii](gii.md)会在ModelBase中会生成带英文版，在Model生成数据表中文注释的，如果需要英文版，则去掉Model中的attributeLabels()方法
- ModelBase中添加自定义的代码，Model文件不要修改
- 当有添加新字段时候，只生成Model文件即可，这样不会覆盖掉ModelBase中的自定义代码
- Funboot框架的模块在common/model/base/目录下，自定义模块的可以在common/models/your/目录下。
- Yii2原本的User内容移到UserBase中，User使用生成的代码，表结构有更新时直接覆盖User即可

### 控制器默认方法

在backend/controllers/BaseController中，框架默认提供以下函数
- /index 默认列表
- /edit 新页面编辑
- /edit-ajax 弹出框编辑
- /edit-ajax-field/{$id} 列表页快速更新
- /edit-ajax-status/{$id}/{$status} 列表页启用禁用
- /delete/{$id} 删除
- /export 导出数据
- /import-ajax 导入数据

如果需要自定义修改某个函数，在[Gii](gii.md)生成的controller中覆盖该方法即可


### 状态码
返回码参考http状态码，框架默认的操作返回码在common/config/params.php中.
- 200 => '操作成功',
- 403 => '没有权限',
- 404 => '不存在',
- 422 => '输入参数错误',
- 500 => '操作失败',

在controller中直接调用 $this->error(422); 即在msg中返回后面的描述





