<?php

use yii\db\Migration;

class m130524_201901_oauth extends Migration
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

DROP TABLE IF EXISTS `fb_oauth_client`;
CREATE TABLE `fb_oauth_client` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客户ID',
  `client_secret` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客户Secret',
  `redirect_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '回调Uri',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `oauth_client_k0` (`store_id`),
  CONSTRAINT `oauth_client_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='OAuth客户';

DROP TABLE IF EXISTS `fb_oauth_authorization_code`;
CREATE TABLE `fb_oauth_authorization_code` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客户ID',
  `scope` json COMMENT '范围',
  `expired_at` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `redirect_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '回调Uri',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `oauth_authorization_code_k0` (`store_id`),
  CONSTRAINT `oauth_authorization_code_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='OAuth验证码';

DROP TABLE IF EXISTS `fb_oauth_access_token`;
CREATE TABLE `fb_oauth_access_token` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客户ID',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '用户',
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '访问Token',
  `scope` json COMMENT '范围',
  `expired_at` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `grant_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '授权类型',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `oauth_access_token_k0` (`store_id`),
  CONSTRAINT `oauth_access_token_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Oauth访问Token';

DROP TABLE IF EXISTS `fb_oauth_refresh_token`;
CREATE TABLE `fb_oauth_refresh_token` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客户ID',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '用户',
  `refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '访问Token',
  `scope` json COMMENT '范围',
  `expired_at` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `grant_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '授权类型',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_token_k0` (`store_id`),
  CONSTRAINT `oauth_refresh_token_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Oauth访问Token';

SET FOREIGN_KEY_CHECKS=1;

INSERT INTO `fb_base_setting_type` VALUES ('87', '1', '0', 'backend', 'Oauth2', 'oauth', '', 3, 64, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8701', '1', '87', 'backend', 'RSA Public', 'oauth_rsa_public', 'RSA公钥绝对路径，Linux下权限600或660', 7, 1, 'text', '', '@common/config/oauth2_public.key', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8703', '1', '87', 'backend', 'RSA Public', 'oauth_rsa_private', 'RSA私钥绝对路径，Linux下权限600或660', 7, 1, 'text', '', '@common/config/oauth2_private.key', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8705', '1', '87', 'backend', '私钥文件加密', 'oauth_rsa_private_encryption', '', 7, 1, 'radioList', '0:否,1:是', '0', '50', '1', '1601008532', '1601008544', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8707', '1', '87', 'backend', '私钥加密密码', 'oauth_rsa_private_password', '', 7, 1, 'text', '', '', '50', '1', '1601008532', '1601008544', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8709', '1', '87', 'backend', '加密密钥字符串', 'oauth_encryption_key', '', 7, 1, 'secretKeyText', '32', '', '50', '1', '1601008532', '1601008544', '1', '1');


        ";

        $this->execute($sql);
    }

    public function down()
    {
    }
}
