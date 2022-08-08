<?php

use yii\db\Migration;

class m220323_173325_v11 extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $sql = "
SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE `fb_base_message` ADD COLUMN `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点' AFTER `store_id`;
ALTER TABLE `fb_base_message` MODIFY COLUMN `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态';
update `fb_base_message` set status = 9 where status = 0;
update `fb_base_message` set status = 0 where status = 1;
update `fb_base_message` set status = 1 where status = 9;
INSERT INTO `fb_base_message_type` VALUES ('3', '1', 'message', null, '0', '2', null, '3', '50', '1', '1', '1', '1', '1');
ALTER TABLE `fb_user` ADD COLUMN `message_count` int(11) NOT NULL DEFAULT '0' COMMENT '消息数量' after `remark`;
ALTER TABLE `fb_user` ADD COLUMN `coupon_count` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券数' after `message_count`;

ALTER TABLE `fb_store` ADD COLUMN `fund` decimal(10,3) NOT NULL DEFAULT '0.00' COMMENT '资金' after `lang_api_default`;
ALTER TABLE `fb_store` ADD COLUMN `fund_amount` decimal(10,3) NOT NULL DEFAULT '0.00' COMMENT '资金总量' after `fund`;
ALTER TABLE `fb_store` ADD COLUMN `billable_fund` decimal(10,3) NOT NULL DEFAULT '0.00' COMMENT '可开票金额' after `fund_amount`;
ALTER TABLE `fb_store` ADD COLUMN `income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入' after `billable_fund`;
ALTER TABLE `fb_store` ADD COLUMN `income_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入总量' after `income`;
ALTER TABLE `fb_store` ADD COLUMN `income_count` int(11) NOT NULL DEFAULT '0' COMMENT '收入数量' after `income_amount`;

ALTER TABLE `fb_store` ADD COLUMN `grade` int(11) NOT NULL DEFAULT '1' COMMENT '级别' after `param6`;
ALTER TABLE `fb_base_setting_type` ADD COLUMN `grade` int(11) NOT NULL DEFAULT '1' COMMENT '级别' after `value_default`;
ALTER TABLE `fb_base_setting` ADD COLUMN `grade` int(11) NOT NULL DEFAULT '1' COMMENT '级别' after `value`;

ALTER TABLE `fb_store` ADD COLUMN `chain` text COMMENT '连锁' after `param6`;

DROP TABLE IF EXISTS `fb_base_fund_log`;
CREATE TABLE `fb_base_fund_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `change` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动',
  `original` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原值',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_fund_log_k0` (`store_id`),
  KEY `base_fund_log_k1` (`user_id`),
  CONSTRAINT `base_fund_log_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_fund_log_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='资金记录';

DROP TABLE IF EXISTS `fb_base_invoice`;
CREATE TABLE `fb_base_invoice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `tax_no` varchar(255) NOT NULL DEFAULT '' COMMENT '税号',
  `content` text COMMENT '内容',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_invoice_k1` (`user_id`),
  KEY `base_invoice_k0` (`store_id`),
  CONSTRAINT `base_invoice_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_invoice_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='发票';

DROP TABLE IF EXISTS `fb_base_recharge`;
CREATE TABLE `fb_base_recharge` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `sn` varchar(255) NOT NULL COMMENT '编号',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `payment_method` int(11) NOT NULL DEFAULT '1' COMMENT '支付方式',
  `payment_status` int(11) NOT NULL DEFAULT '20' COMMENT '支付状态',
  `paid_at` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '税费',
  `invoice` varchar(255) NOT NULL DEFAULT '' COMMENT '发票',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_recharge_k0` (`store_id`),
  KEY `base_recharge_k3` (`user_id`),
  CONSTRAINT `base_recharge_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_recharge_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='充值';


-- INSERT INTO `fb_base_permission` VALUES ('59', '1', '5', '财务管理', 'backend', '', '', 'fas fa-money-bill', '', '2', '0', '1', '50', '1', '1599358163', '1599358163', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('591', '1', '59', '充值管理', 'backend', '', '/base/recharge/index', 'fas fa-credit-card', '', '3', '0', '1', '50', '1', '1599358163', '1599358163', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('592', '1', '59', '发票管理', 'backend', '', '/base/invoice/index', 'fas fa-receipt', '', '3', '0', '1', '50', '1', '1599358163', '1599358163', '1', '1');



update `fb_base_permission` set `name` = '系统设置' where id=56;
INSERT INTO `fb_base_permission` VALUES ('5670', '1', '567', '设置列表', 'backend', '', '/base/setting/index*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES (10001, '1', '', '50', '5670', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES (10002, 1, '', 54, 5670, 1, 50, 1, 1634178360, 1634178360, 1, 1);
INSERT INTO `fb_base_role_permission` VALUES (10003, 1, '', 56, 5670, 1, 50, 1, 1634178459, 1634178459, 1, 1);
INSERT INTO `fb_base_role_permission` VALUES (10004, 1, '', 55, 5670, 1, 50, 1, 1634178504, 1634178504, 1, 1);



ALTER table `fb_base_role_permission` auto_increment = 100000;
ALTER table `fb_base_permission` auto_increment = 100000;
ALTER table `fb_base_setting_type` auto_increment = 100000;
ALTER table `fb_base_message_type` auto_increment = 1000;

ALTER table `fb_mall_coupon_type` auto_increment = 1000;

INSERT INTO `fb_base_role` VALUES ('49', '1', 'agent', '0', 'Agent', '', '60', '50', '1', '1599461439', '1603418493', '1', '1');



DROP TABLE IF EXISTS `fb_school_teacher`;
CREATE TABLE `fb_school_teacher` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `is_default` int(11) NOT NULL DEFAULT 1 COMMENT '是否默认',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `school_teacher_fk0` (`store_id`),
  CONSTRAINT `school_teacher_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '老师';

ALTER TABLE `fb_mall_coupon_type` ADD COLUMN `max_times` int(11) NOT NULL DEFAULT '1' COMMENT '最大数量' after `min_amount`;

SET FOREIGN_KEY_CHECKS=1;
        ";

        $this->execute($sql);


        //add data
        $sql = "
SET FOREIGN_KEY_CHECKS=0;

SET FOREIGN_KEY_CHECKS=1;
        ";

        //add user: admin  password: 123456
        $this->execute($sql);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
