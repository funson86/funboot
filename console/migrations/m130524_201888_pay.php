<?php

use yii\db\Migration;

class m130524_201888_pay extends Migration
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
CREATE TABLE `fb_pay_payment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付方式',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '捐赠金额',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '昵称',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `email_exp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '体验管理员邮箱',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '留言',
  `sn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '序列号',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `pay_payment_k1` (`bank_code`),
  KEY `pay_payment_k2` (`store_id`),
  CONSTRAINT `pay_payment_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='支付';

INSERT INTO `fb_base_permission` VALUES ('55', '1', '5', 'Funpay', 'backend', '', '', 'fas fa-dollar-sign', '', '2', '0', '1', '50', '1', '1599358163', '1599358163', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('551', '1', '55', '支付管理', 'backend', '', '/pay/payment/index', 'fas fa-money-check-alt', '', '3', '0', '1', '50', '1', '1', '1602322615', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('5511', '1', '551', '查看', 'backend', '', '/pay/payment/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5512', '1', '551', '编辑', 'backend', '', '/pay/payment/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5513', '1', '551', '删除', 'backend', '', '/pay/payment/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5514', '1', '551', '启禁', 'backend', '', '/pay/payment/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5515', '1', '551', '导出', 'backend', '', '/pay/payment/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5516', '1', '551', '导入', 'backend', '', '/pay/payment/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');

INSERT INTO `fb_base_role_permission` VALUES ('1020', '1', '', '50', '5', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('1021', '1', '', '50', '55', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('1022', '1', '', '50', '551', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('1023', '1', '', '50', '5511', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('1024', '1', '', '50', '5512', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('1025', '1', '', '50', '5513', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('1026', '1', '', '50', '5514', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('1027', '1', '', '50', '5515', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('1028', '1', '', '50', '5516', '1', '50', '1', '1602505044', '1606818825', '1', '1');



        ";

        $this->execute($sql);
    }

    public function down()
    {
    }
}
