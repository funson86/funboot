Convention priority over config
-----------

Table of contents

- Subsystem keyword Convention
- Sql design Convention
- RBAC Convention
- Setting Convention


Convention priority over config is a feature of Yii framework. For example yii route site/index specify to actionIndex in SiteController
You can config the urlManager with self route rule. 

Funboot also follows the principle which can greatly improve the development speed and reduce the maintenance cost.


### Subsystem keyword Convention

Funboot contains some subsystem, you can override the subsystem or use another keyword to develop. 

For the router of keyword is used in funboot, It may conflict.

- pay：FunPay use router：/pay/default/*
- cms：FunPay use router: /cms/default/*


### Sql design Convention

- int use int(11), varchar use 255/32/64/128/190/1022 length, always use 255，timestamp use int(11);
- id use bigint(20) unsigned uniformly, which is also convenient for adding and deleting foreign keys. The field use table_id if related to other table with a foregin key. For example, the user_id field in table fb_mall_address is relate to table fb_user.
- If the project is distributed, the Snowlake algorithm can be used. Specify the $highConcurrency to true in modelBase .
- Funboot use the table structure below. Recommend to add your field/index/foreign keys based on it. It is recommended to add foreign keys in development stage, and remove it in the online environment.
- The field of table definition below should be keep in your table definition. If not required like `name`, change it to  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name' for view in the backend.
- Add COMMENT for every field in table definition, use [Funboot Gii](dev-gii.md) create label of comment and support i18n.

```sql
DROP TABLE IF EXISTS `fb_template`;
CREATE TABLE `fb_template` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT 'Store',
  `name` varchar(255) NOT NULL COMMENT 'Name',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT 'Type',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT 'Sort',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT 'Status',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT 'Created At',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT 'Updated At',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT 'Created By',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT 'Updated By',
  PRIMARY KEY (`id`),
  KEY `template_k0` (`store_id`),
  CONSTRAINT `template_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT 'Template';
```

### RBAC Convention

Refer to [RBAC Role-based access control](dev-rbac.md)


### Setting Convention

- Recommend insert setting types to fb_base_setting_type. You can view the relation by ID. For example, 50, 5001 and 5003 is the children of 10.

- Code use parent code as the prefix. For example 10 code is website, the 5001 code is website_name the 5003 code is website_logo.

- The length of ID is 4 usually


```
INSERT INTO `fb_base_setting_type` VALUES ('50', '1', '0', 'backend', 'Website', 'website', '', 7, 1, 'text', '', '', '50', '1', '1600948343', '1600948343', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5001', '1', '50', 'backend', 'Website Name', 'website_name', '', 7, 1, 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5003', '1', '50', 'backend', 'Website Logo', 'website_logo', '', 7, 1, 'image', '', '', '50', '1', '1600948430', '1600948430', '1', '1');

```


- If add setting type in the backend, the id wil auto increase in mysql.

