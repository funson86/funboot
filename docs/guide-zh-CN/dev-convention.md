约定优先配置
-----------
目录

- 子系统关键字约定
- 数据表sql设计约定
- RBAC权限控制约定
- 配置约定


Yii一大特性是约定优先配置，比如yii的路由site/index映射SiteController的actionIndex方法，如果要特殊指定也可以在配置文件中指定，不像其他框架每个router都指定，当团队成员不遵循规范时项目维护难度很大。

Funboot框架也遵循约定优先配置原则，遵循以下约定可以极大的提升开发速度和降低维护成本。


### 子系统关键字约定

Funboot包含一些子系统，可以在这些子系统上直接进行二次开发提交官方，也可以使用其他关键字重新开发。

因为这些关键字对应的router已经被funboot占用，尽可能避免和这些关键字冲突。

- pay：FunPay使用router：/pay/default/*
- cms：FunPay使用router:/cms/default/*


### 数据表sql设计约定

- int统一使用int(11), varchar使用255/32/64/128/1022长度，一般无特别之处用255，时间统一用int(11);
- id统一使用bigint(20)，也便于添加删除外键，关联其他表的外键id一般使用 表_id方式，如关联user表，则命名为user_id，批量替换时候也可以根据 _id` 批量替换类型。
- 如果项目分布式，可以使用雪花算法，数据表无需任何修改，只需要BaseController中的findModel中new之后添加字符串$model->id;
- 框架默认的使用如下表结构，建议在此表结构上添加自定义的字段、索引和外键。推荐开发阶段和测试环境添加外键，线上环境去掉外键。
- 数据表增加COMMENT描述，使用[Funboot的Gii](gii.md)会在Model文件中生成中英双语标签，无需编写众多的i18n翻译文件。
- 模板表中字段请尽量保留，暂时用不上的，随着系统功能叠加某天会用上时就无需修改数据表，对于关系表中name可以修改为  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称', 以兼容后台生成代码的展现。

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

### RBAC权限控制约定

参见[RBAC权限控制组件](dev-rbac.md)：每个用户对应一个角色，不同角色包含不同权限


### 配置约定

- 推荐使用数据表插入的方式，可以清晰的通过ID查看相关度，每次使用两位代码如10，子ID为1001、1003等。

- Code也使用父code做前缀的方式，10的code为website，1001为website_name，1003为website_logo。

- 一般而言4位代码足够用了


```
INSERT INTO `fb_base_setting_type` VALUES ('10', '1', '0', 'backend', '网站设置', 'website', '', 'text', '', '', '50', '1', '1600948343', '1600948343', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('1001', '1', '10', 'backend', '网站标题', 'website_name', '', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('1003', '1', '10', 'backend', '网站Logo', 'website_logo', '', 'image', '', '', '50', '1', '1600948430', '1600948430', '1', '1');

```


- 如果最终移交给用户，也可以在后台通过界面创建，不过ID变为自增。

