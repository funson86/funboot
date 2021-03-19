<?php

use yii\db\Migration;

class m130524_201916_wechat extends Migration
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

DROP TABLE IF EXISTS `fb_wechat_fan`;
CREATE TABLE `fb_wechat_fan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `unionid` varchar(255) NOT NULL DEFAULT '' COMMENT '唯一微信ID',
  `openid` varchar(255) NOT NULL COMMENT 'Open Id',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `sex` int(11) NOT NULL DEFAULT '1' COMMENT '性别',
  `groupid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '组号',
  `subscribe` int(11) NOT NULL DEFAULT '1' COMMENT '关注',
  `subscribe_time` int(11) NOT NULL DEFAULT '1' COMMENT '关注时间',
  `subscribe_scene` varchar(255) NOT NULL DEFAULT '' COMMENT '关注场景',
  `tagid_list` json default null COMMENT '标签',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `country` varchar(255) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(255) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '城市',
  `language` varchar(255) NOT NULL DEFAULT '' COMMENT '语言',
  `qr_scene` int(11) NOT NULL DEFAULT '1' COMMENT '二维码场景',
  `qr_scene_str` varchar(255) NOT NULL DEFAULT '' COMMENT '二维码场景描述',
  `last_longitude` varchar(255) NOT NULL DEFAULT '' COMMENT '最后一次经度',
  `last_latitude` varchar(255) NOT NULL DEFAULT '' COMMENT '最后一次纬度',
  `last_address` varchar(255) NOT NULL DEFAULT '' COMMENT '最后一次地址',
  `last_updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '最后一次时间',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `wechat_fan_fk2` (`store_id`),
  CONSTRAINT `wechat_fan_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '粉丝';

DROP TABLE IF EXISTS `fb_wechat_tag`;
CREATE TABLE `fb_wechat_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `tags` json default null COMMENT '标签',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `wechat_tag_fk2` (`store_id`),
  CONSTRAINT `wechat_tag_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '标签';

DROP TABLE IF EXISTS `fb_wechat_fan_tag`;
CREATE TABLE `fb_wechat_fan_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `fan_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '粉丝',
  `tag_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '标签',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `wechat_fan_tag_fk2` (`store_id`),
  CONSTRAINT `wechat_fan_tag_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `wechat_fan_tag_fk3` FOREIGN KEY (`fan_id`) REFERENCES `fb_wechat_fan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '粉丝标签关系';


DROP TABLE IF EXISTS `fb_wechat_qrcode`;
CREATE TABLE `fb_wechat_qrcode` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关联关键字',
  `scene_id` int(11) NOT NULL DEFAULT 0 COMMENT '场景ID',
  `scene_str` varchar(255) NOT NULL DEFAULT '' COMMENT '场景值',
  `expired_second` int(11) NOT NULL DEFAULT 2592000 COMMENT '过期秒数',
  `expired_at` int(11) NOT NULL DEFAULT 0 COMMENT '截止时间',
  `ticket` varchar(255) NOT NULL DEFAULT '' COMMENT '微信凭证',
  `subscribe_count` int(11) NOT NULL DEFAULT 0 COMMENT '扫描次数',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `wechat_qrcode_fk2` (`store_id`),
  CONSTRAINT `wechat_qrcode_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '推广二维码';

DROP TABLE IF EXISTS `fb_wechat_material`;
CREATE TABLE `fb_wechat_material` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT 'Url',
  `media_type` varchar(255) NOT NULL DEFAULT '' COMMENT '资源类型',
  `media_id` varchar(255) NOT NULL DEFAULT '' COMMENT '微信资源ID',
  `media_url` varchar(255) NOT NULL DEFAULT '' COMMENT '资源Url',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `year` int(11) NOT NULL DEFAULT '0' COMMENT '年份',
  `month` int(11) NOT NULL DEFAULT '0' COMMENT '月份',
  `day` int(11) NOT NULL DEFAULT '0' COMMENT '日',
  `width` int(11) NOT NULL DEFAULT '0' COMMENT '宽度',
  `height` int(11) NOT NULL DEFAULT '0' COMMENT '高度',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `wechat_material_fk2` (`store_id`),
  CONSTRAINT `wechat_material_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '素材';

DROP TABLE IF EXISTS `fb_wechat_material_news`;
CREATE TABLE `fb_wechat_material_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT 'Url',
  `media_type` varchar(255) NOT NULL DEFAULT '' COMMENT '资源类型',
  `media_id` varchar(255) NOT NULL DEFAULT '' COMMENT '微信资源ID',
  `media_url` varchar(255) NOT NULL DEFAULT '' COMMENT '资源Url',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `year` int(11) NOT NULL DEFAULT '0' COMMENT '年份',
  `month` int(11) NOT NULL DEFAULT '0' COMMENT '月份',
  `day` int(11) NOT NULL DEFAULT '0' COMMENT '日',
  `width` int(11) NOT NULL DEFAULT '0' COMMENT '宽度',
  `height` int(11) NOT NULL DEFAULT '0' COMMENT '高度',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `wechat_material_fk2` (`store_id`),
  CONSTRAINT `wechat_material_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '素材';


        ";

        $this->execute($sql);


        $sql = "
SET FOREIGN_KEY_CHECKS=0;

INSERT INTO `fb_base_permission` VALUES ('3', '1', '0', '微信', 'backend', '', '', 'fab fa-weixin', '', '1', '0', '1', '50', '1', '1', '1599358085', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('31', '1', '3', '粉丝管理', 'backend', '', '', 'fas fa-users', '', '2', '0', '1', '50', '1', '1', '1599358085', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('311', '1', '31', '粉丝列表', 'backend', '', '/wechat/fan/index', 'fas fa-user-friends', '', '3', '0', '1', '50', '1', '1', '1599358085', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('313', '1', '31', '粉丝标签', 'backend', '', '/wechat/tag/index', 'fas fa-tags', '', '3', '0', '1', '50', '1', '1', '1599358085', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('35', '1', '3', '高级功能', 'backend', '', '', 'fas fa-wrench', '', '2', '0', '1', '50', '1', '1', '1599358085', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('351', '1', '35', '自定义菜单', 'backend', '', '/wechat/menu/index', 'fas fa-ellipsis-h', '', '3', '0', '1', '50', '1', '1', '1599358085', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('353', '1', '35', '推广二维码', 'backend', '', '/wechat/qrcode/index', 'fas fa-qrcode', '', '3', '0', '1', '50', '1', '1', '1599358085', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('3111', '1', '311', '查看', 'backend', '', '/wechat/fan/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3112', '1', '311', '编辑', 'backend', '', '/wechat/fan/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3113', '1', '311', '删除', 'backend', '', '/wechat/fan/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3114', '1', '311', '启禁', 'backend', '', '/wechat/fan/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3115', '1', '311', '导出', 'backend', '', '/wechat/fan/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3116', '1', '311', '导入', 'backend', '', '/wechat/fan/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3131', '1', '313', '查看', 'backend', '', '/wechat/tag/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3132', '1', '313', '编辑', 'backend', '', '/wechat/tag/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3133', '1', '313', '删除', 'backend', '', '/wechat/tag/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3134', '1', '313', '启禁', 'backend', '', '/wechat/tag/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3135', '1', '313', '导出', 'backend', '', '/wechat/tag/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3136', '1', '313', '导入', 'backend', '', '/wechat/tag/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3511', '1', '351', '查看', 'backend', '', '/wechat/menu/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3512', '1', '351', '编辑', 'backend', '', '/wechat/menu/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3513', '1', '351', '删除', 'backend', '', '/wechat/menu/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3514', '1', '351', '启禁', 'backend', '', '/wechat/menu/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3515', '1', '351', '导出', 'backend', '', '/wechat/menu/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3516', '1', '351', '导入', 'backend', '', '/wechat/menu/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3531', '1', '353', '查看', 'backend', '', '/wechat/qrcode/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3532', '1', '353', '编辑', 'backend', '', '/wechat/qrcode/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3533', '1', '353', '删除', 'backend', '', '/wechat/qrcode/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3534', '1', '353', '启禁', 'backend', '', '/wechat/qrcode/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3535', '1', '353', '导出', 'backend', '', '/wechat/qrcode/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('3536', '1', '353', '导入', 'backend', '', '/wechat/qrcode/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');


INSERT INTO `fb_base_setting_type` VALUES ('72', '1', '0', 'backend', '微信公众号', 'wechat', '', 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('74', '1', '0', 'backend', '微信小程序', 'mini', '', 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('78', '1', '0', 'backend', '支付配置', 'pay', '', 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');

INSERT INTO `fb_base_setting_type` VALUES ('7201', '1', '72', 'backend', '公众号帐号', 'wechat_account', '公众号帐号，一般为英文帐号或邮箱', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7203', '1', '72', 'backend', '公众号原始ID', 'wechat_id', '建议完善，给用户发客服消息时需要，位于右上角【帐号详情】》【注册信息】中', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7205', '1', '72', 'backend', '公众号级别', 'wechat_rank', '注意：即使公众平台显示为“未认证”, 但只要【公众号设置】》【账号详情】下【认证情况】显示资质审核通过, 即可认定为认证号.', 'radioList', '1:普通订阅号,2:普通服务号,3:认证订阅号,4:认证服务号/认证媒体/政府订阅号', '1', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7211', '1', '72', 'backend', '开发者ID', 'wechat_appid', '开发者AppID位于左侧【开发】》【基本配置】》【公众号开发信息】中', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7213', '1', '72', 'backend', '开发者密码App Secret', 'wechat_appsecret', '开发者密码AppSecret位于左侧【开发】》【基本配置】》【公众号开发信息】中', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7215', '1', '72', 'backend', '令牌Token', 'wechat_token', '令牌Token位于左侧【开发】》【基本配置】》【服务器配置】中', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7217', '1', '72', 'backend', '加解密密钥', 'wechat_encodingaeskey', '加解密密钥EncodingAESKey位于左侧【开发】》【服务器配置】》【公众号开发信息】中', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7221', '1', '72', 'backend', '微信公众号二维码', 'wechat_qrcode', '', 'image', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7231', '1', '72', 'backend', '分享标题', 'wechat_share_title', '', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7233', '1', '72', 'backend', '分享简介', 'wechat_share_brief', '', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7235', '1', '72', 'backend', '分享图片', 'wechat_share_image', '', 'image', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7237', '1', '72', 'backend', '分享链接', 'wechat_share_url', '', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');

INSERT INTO `fb_base_setting_type` VALUES ('7811', '1', '78', 'backend', '微信支付商户号', 'pay_wechat_mchid', '支付的商户账号', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7812', '1', '78', 'backend', '微信支付支付密钥', 'pay_wechat_api_key', '', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7813', '1', '78', 'backend', '微信支付证书公钥', 'pay_wechat_cert_path', '如需使用敏感接口(如退款、发送红包等)需要配置 API 证书路径(登录商户平台下载 API 证书),注意路径为绝对路径', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7814', '1', '78', 'backend', '微信支付证书私钥', 'pay_wechat_key_path', '如需使用敏感接口(如退款、发送红包等)需要配置 API 证书路径(登录商户平台下载 API 证书),注意路径为绝对路径', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7815', '1', '78', 'backend', '微信支付App ID', 'pay_wechat_open_appid', '主要用于 app 支付，微信开放平台的 appid，如果只需要微信公众号支付，只配置微信公众号那边即可', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('7816', '1', '78', 'backend', '微信支付App ID', 'pay_wechat_rsa_public_key_path', '企业付款需要用到双向证书，请参考：https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=4_3', 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');


        ";

        //add user: admin  password: 123456
        $this->execute($sql);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
