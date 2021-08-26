<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
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

-- ----------------------------
-- Table structure for fb_base_attachment
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_attachment`;
CREATE TABLE `fb_base_attachment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '存储位置',
  `upload_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '上传类型',
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件类型',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '本地路径',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Url地址',
  `md5` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Md5值',
  `size` int(11) NOT NULL DEFAULT '1' COMMENT '文件大小',
  `ext` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '后缀',
  `year` int(11) NOT NULL DEFAULT '0' COMMENT '年份',
  `month` int(11) NOT NULL DEFAULT '0' COMMENT '月份',
  `day` int(11) NOT NULL DEFAULT '0' COMMENT '日',
  `width` int(11) NOT NULL DEFAULT '0' COMMENT '宽度',
  `height` int(11) NOT NULL DEFAULT '0' COMMENT '高度',
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '上传IP',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_attachment_fk2` (`store_id`),
  CONSTRAINT `base_attachment_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文件';

-- ----------------------------
-- Table structure for fb_base_department
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_department`;
CREATE TABLE `fb_base_department` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend' COMMENT '子系统',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `head` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '负责人',
  `vice_head` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '副负责人',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '层级',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_department_fk2` (`store_id`),
  CONSTRAINT `base_department_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='部门';

-- ----------------------------
-- Table structure for fb_base_dict
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_dict`;
CREATE TABLE `fb_base_dict` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '代码',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_dict_k2` (`store_id`),
  CONSTRAINT `base_dict_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='字典';

-- ----------------------------
-- Table structure for fb_base_dict_data
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_dict_data`;
CREATE TABLE `fb_base_dict_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `dict_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '字典',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '代码',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '值',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_dict_data_k2` (`store_id`),
  KEY `base_dict_data_k1` (`dict_id`),
  CONSTRAINT `base_dict_data_fk1` FOREIGN KEY (`dict_id`) REFERENCES `fb_base_dict` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_dict_data_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='字典数据';

-- ----------------------------
-- Table structure for fb_base_log
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_log`;
CREATE TABLE `fb_base_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Url',
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'GET' COMMENT '提交方式',
  `params` text COLLATE utf8mb4_unicode_ci COMMENT '请求数据',
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'UA信息',
  `agent_type` int(11) NOT NULL DEFAULT '200' COMMENT '终端类型',
  `ip` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'IP地址',
  `ip_info` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'IP信息',
  `code` int(11) NOT NULL DEFAULT '200' COMMENT '返回码',
  `msg` mediumtext COMMENT '返回信息',
  `data` mediumtext COLLATE utf8mb4_unicode_ci COMMENT '数据',
  `cost_time` decimal(10,6) NOT NULL DEFAULT '1.000000' COMMENT '耗时',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_log_fk2` (`store_id`),
  CONSTRAINT `base_log_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='日志';

-- ----------------------------
-- Table structure for fb_base_message_type
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_message_type`;
CREATE TABLE `fb_base_message_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `send_type` int(11) NOT NULL DEFAULT '0' COMMENT '发送类型',
  `send_target` int(11) NOT NULL DEFAULT '1' COMMENT '发送对象',
  `send_user` text COLLATE utf8mb4_unicode_ci COMMENT '发送用户',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_message_type_fk2` (`store_id`),
  CONSTRAINT `base_message_type_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='消息类型';

-- ----------------------------
-- Table structure for fb_base_message
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_message`;
CREATE TABLE `fb_base_message` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '用户',
  `from_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '发送用户',
  `message_type_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '消息',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_message_fk0` (`user_id`),
  KEY `base_message_fk9` (`from_id`),
  KEY `base_message_fk1` (`message_type_id`),
  KEY `base_message_fk2` (`store_id`),
  CONSTRAINT `base_message_fk0` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_message_fk1` FOREIGN KEY (`message_type_id`) REFERENCES `fb_base_message_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_message_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_message_fk9` FOREIGN KEY (`from_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='消息';

-- ----------------------------
-- Table structure for fb_base_permission
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_permission`;
CREATE TABLE `fb_base_permission` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend' COMMENT '子系统',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '路径',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图标',
  `tree` varchar(1022) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '树路径',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '层级',
  `target` int(11) NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_permission_fk2` (`store_id`),
  CONSTRAINT `base_permission_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限';

-- ----------------------------
-- Table structure for fb_base_role
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_role`;
CREATE TABLE `fb_base_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否为默认',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `tree` varchar(1022) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '树路径',
  `type` int(11) NOT NULL DEFAULT '60' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_role_fk2` (`store_id`),
  CONSTRAINT `base_role_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色';

-- ----------------------------
-- Table structure for fb_base_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_role_permission`;
CREATE TABLE `fb_base_role_permission` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `role_id` bigint(20) unsigned NOT NULL COMMENT '角色',
  `permission_id` bigint(20) unsigned NOT NULL COMMENT '权限',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_role_permission_fk2` (`store_id`),
  KEY `base_role_permission_fk0` (`role_id`),
  KEY `base_role_permission_fk1` (`permission_id`),
  CONSTRAINT `base_role_permission_fk0` FOREIGN KEY (`role_id`) REFERENCES `fb_base_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_role_permission_fk1` FOREIGN KEY (`permission_id`) REFERENCES `fb_base_permission` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_role_permission_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色菜单权限';

-- ----------------------------
-- Table structure for fb_base_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_role_department`;
CREATE TABLE `fb_base_role_department` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `role_id` bigint(20) unsigned NOT NULL COMMENT '角色',
  `department_id` bigint(20) unsigned NOT NULL COMMENT '部门',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_role_department_fk2` (`store_id`),
  KEY `base_role_department_fk0` (`role_id`),
  KEY `base_role_department_fk1` (`department_id`),
  CONSTRAINT `base_role_department_fk0` FOREIGN KEY (`role_id`) REFERENCES `fb_base_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_role_department_fk1` FOREIGN KEY (`department_id`) REFERENCES `fb_base_department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_role_department_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色数据权限';

-- ----------------------------
-- Table structure for fb_base_schedule
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_schedule`;
CREATE TABLE `fb_base_schedule` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `params` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '参数',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `cron` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '* * * * *' COMMENT 'Cron表达式',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_schedule_fk2` (`store_id`),
  CONSTRAINT `base_schedule_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='定时任务';

-- ----------------------------
-- Table structure for fb_base_setting
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_setting`;
CREATE TABLE `fb_base_setting` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend' COMMENT '子系统',
  `setting_type_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '配置类型',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '代码',
  `value` text COLLATE utf8mb4_unicode_ci COMMENT '值',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_setting_k0` (`store_id`),
  CONSTRAINT `base_setting_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配置';

-- ----------------------------
-- Table structure for fb_base_setting_type
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_setting_type`;
CREATE TABLE `fb_base_setting_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend' COMMENT '子系统',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `code` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '代码',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `support_role` int(11) NOT NULL DEFAULT '7' COMMENT '支持角色',
  `support_system` int(11) NOT NULL DEFAULT '1' COMMENT '支持系统',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text' COMMENT '类型',
  `value_range` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '可选值',
  `value_default` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '默认值',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY `base_setting_type_code` (`code`),
  KEY `base_setting_type_k0` (`store_id`),
  CONSTRAINT `base_setting_type_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配置类型';

-- ALTER TABLE `fb_base_setting_type` ADD COLUMN `support_role` int(11) NOT NULL DEFAULT '7' COMMENT '支持角色' AFTER `brief`;  
-- ALTER TABLE `fb_base_setting_type` ADD COLUMN `support_system` int(11) NOT NULL DEFAULT '1' COMMENT '支持系统' AFTER `support_role`;  

-- ----------------------------
-- Table structure for fb_base_user_role
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_user_role`;
CREATE TABLE `fb_base_user_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `role_id` bigint(20) unsigned NOT NULL COMMENT '角色',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_user_role_fk2` (`store_id`),
  KEY `base_user_role_fk0` (`user_id`),
  KEY `base_user_role_fk1` (`role_id`),
  CONSTRAINT `base_user_role_fk0` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_user_role_fk1` FOREIGN KEY (`role_id`) REFERENCES `fb_base_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_user_role_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色菜单权限';

-- ----------------------------
-- Table structure for fb_store
-- ----------------------------
DROP TABLE IF EXISTS `fb_store`;
CREATE TABLE `fb_store` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '管理员',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `host_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '域名',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '代码',
  `qrcode` varchar(255) NOT NULL DEFAULT '' COMMENT '二维码',
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'site' COMMENT '子系统',
  `expired_at` int(11) NOT NULL DEFAULT '0' COMMENT '到期时间',
  `remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '备注',
  `language` int(11) NOT NULL DEFAULT '1' COMMENT '语言',
  `lang_source` varchar(255) NOT NULL DEFAULT 'zh-CN' COMMENT '翻译源语言',
  `lang_frontend` int(11) NOT NULL DEFAULT '3' COMMENT '前端支持语言',
  `lang_frontend_default` varchar(255) NOT NULL DEFAULT '' COMMENT '前端默认语言',
  `lang_backend` int(11) NOT NULL DEFAULT '3' COMMENT '后端支持语言',
  `lang_backend_default` varchar(255) NOT NULL DEFAULT '' COMMENT '后端默认语言',
  `lang_api` int(11) NOT NULL DEFAULT '3' COMMENT 'API支持语言',
  `lang_api_default` varchar(255) NOT NULL DEFAULT '' COMMENT 'API默认语言',  
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_store_fk1` (`user_id`),
  CONSTRAINT `base_store_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='店铺';

-- ALTER TABLE `fb_store` ADD COLUMN `code` varchar(255) NOT NULL DEFAULT '' COMMENT '代码' AFTER `host_name`;  
-- ALTER TABLE `fb_store` ADD COLUMN `lang_source` varchar(255) NOT NULL DEFAULT 'zh-CN' COMMENT '翻译源语言' AFTER `language`;  
-- ALTER TABLE `fb_store` ADD COLUMN `lang_frontend` int(11) NOT NULL DEFAULT '3' COMMENT '前端支持语言' AFTER `lang_source`;  
-- ALTER TABLE `fb_store` ADD COLUMN `lang_frontend_default` varchar(255) NOT NULL DEFAULT '' COMMENT '前端默认语言' AFTER `lang_frontend`;  
-- ALTER TABLE `fb_store` ADD COLUMN `lang_backend` int(11) NOT NULL DEFAULT '3' COMMENT '后端支持语言' AFTER `lang_frontend_default`;  
-- ALTER TABLE `fb_store` ADD COLUMN `lang_backend_default` varchar(255) NOT NULL DEFAULT '' COMMENT '后端默认语言' AFTER `lang_backend`;  
-- ALTER TABLE `fb_store` ADD COLUMN `lang_api` int(11) NOT NULL DEFAULT '3' COMMENT 'API支持语言' AFTER `lang_backend_default`;  
-- ALTER TABLE `fb_store` ADD COLUMN `lang_api_default` varchar(255) NOT NULL DEFAULT '' COMMENT 'API默认语言' AFTER `lang_api`;  

-- ----------------------------
-- Table structure for fb_user
-- ----------------------------
DROP TABLE IF EXISTS `fb_user`;
CREATE TABLE `fb_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '帐号',
  `auth_key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限',
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Token',
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '访问Token',
  `refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '刷新Token',
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `password_reset_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '重置密码',
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '校验Token',
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '微信Id',
  `unionid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '微信唯一Id',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机',
  `auth_role` int(11) NOT NULL DEFAULT '1' COMMENT '用户类型',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `avatar` varchar(1022) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `sex` int(11) NOT NULL DEFAULT '0' COMMENT '性别',
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地区',
  `province_id` int(11) NOT NULL DEFAULT '0' COMMENT '省',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '市',
  `district_id` int(11) NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `birthday` varchar(255) NOT NULL default '' COMMENT '生日',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_at` int(11) NOT NULL DEFAULT '1' COMMENT '最近登录时间',
  `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '最近登录IP',
  `last_paid_at` int(11) NOT NULL DEFAULT '0' COMMENT '最近消费时间',
  `last_paid_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '最近消费IP',
  `consume_count` int(11) NOT NULL DEFAULT '0' COMMENT '消费次数',
  `consume_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY `base_username` (`username`),
  KEY `base_created_at` (`created_at`),
  KEY `base_user_fk2` (`store_id`),
  CONSTRAINT `base_user_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户';

DROP TABLE IF EXISTS `fb_school_student`;
CREATE TABLE `fb_school_student` (
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
  CONSTRAINT `school_student_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '学生';

DROP TABLE IF EXISTS `fb_base_lang`;
CREATE TABLE `fb_base_lang` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `source` varchar(255) NOT NULL COMMENT '源语言',
  `target` varchar(255) NOT NULL COMMENT '目标语言',
  `table_code` int(11) NOT NULL DEFAULT 0 COMMENT '表代码',
  `target_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '目标ID',
  `content` text COMMENT '内容',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_lang_fk2` (`store_id`),
  CONSTRAINT `base_lang_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '多语言';

DROP TABLE IF EXISTS `fb_base_profile`;
CREATE TABLE `fb_base_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `company` varchar(255) NOT NULL DEFAULT '' COMMENT '公司',
  `location` varchar(255) NOT NULL DEFAULT '' COMMENT '城市',
  `topic` int(11) NOT NULL DEFAULT 0 COMMENT '主题数',
  `like` int(11) NOT NULL DEFAULT 0 COMMENT '点赞数',
  `hate` int(11) NOT NULL DEFAULT 0 COMMENT '倒彩数',
  `thanks` int(11) NOT NULL DEFAULT 0 COMMENT '感谢数',
  `follow` int(11) NOT NULL DEFAULT 0 COMMENT '关注数',
  `click` int(11) NOT NULL DEFAULT 0 COMMENT '浏览',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_profile_fk2` (`store_id`),
  CONSTRAINT `base_profile_fk1` FOREIGN KEY (`id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `base_profile_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '用户资料';

-- ----------------------------
-- Table structure for fb_base_attachment
-- ----------------------------
DROP TABLE IF EXISTS `fb_base_search_log`;
CREATE TABLE `fb_base_search_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `session_id` varchar(255) NOT NULL DEFAULT '' COMMENT '会话ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `ip` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_log_fk0` (`store_id`),
  CONSTRAINT `base_log_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='搜索记录';

DROP TABLE IF EXISTS `fb_base_stuff`;
CREATE TABLE `fb_base_stuff` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `code` json default NULL COMMENT '代码',
  `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '值',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Url',
  `position` int(11) NOT NULL DEFAULT '1' COMMENT '位置',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `base_stuff_k0` (`store_id`),
  CONSTRAINT `base_stuff_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='物料';

-- ALTER TABLE `fb_user` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_store` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_base_setting_type` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_base_schedule` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_base_permission` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_base_dict_data` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_base_dict` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_base_department` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_base_role` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_user` ADD `openid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '微信Id' after `verification_token`;
-- ALTER TABLE `fb_user` ADD `unionid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '微信唯一Id' after `openid`;



SET FOREIGN_KEY_CHECKS=1;
        ";

        $this->execute($sql);


        //add user: admin  password: 123456
        $sql = "
SET FOREIGN_KEY_CHECKS=0;

INSERT INTO `fb_store` VALUES ('1', '0', '1', 'Funboot', '默认网站', 'www.funboot.com', '', '', 'site', '1634684399', '默认网站', 32767, 'zh-CN', 32767, '', 32767, '', 32767, '', 0, 50, 1, 1, 1619169177, 1, 1);
INSERT INTO `fb_store` VALUES ('2', '0', '2', 'Funpay', 'Funpay', 'www.funpay.com', '', '', 'pay', '1634684399', 'Funpay', 32767, 'zh-CN', 32767, '', 32767, '', 32767, '', 0, 50, 1, 1, 1619169177, 1, 1);
INSERT INTO `fb_store` VALUES ('4', '0', '4', 'Funcms', 'Funcms', 'www.funcms.com', '', '', 'cms', '1634684399', 'Funcms', 32767, 'zh-CN', 32767, '', 32767, '', 32767, '', 0, 50, 1, 1, 1619169177, 1, 1);
INSERT INTO `fb_store` VALUES ('5', '0', '5', 'Funmall', 'Funmall', 'www.funmall.com', '', '', 'mall', '1634684399', 'Funmall', 32767, 'zh-CN', 32767, '', 32767, '', 32767, '', 0, 50, 1, 1, 1619169177, 1, 1);
INSERT INTO `fb_store` VALUES ('6', '0', '6', 'Funbbs', 'Funbbs', 'www.funbbs.com', '', '', 'bbs', '1634684399', 'Funbbs', 32767, 'zh-CN', 32767, '', 32767, '', 32767, '', 0, 50, 1, 1, 1619169177, 1, 1);

INSERT INTO `fb_user`(`id`, `store_id`, `parent_id`, `username`, `auth_key`, `token`, `access_token`, `password_hash`, `password_reset_token`, `verification_token`, `email`, `mobile`, `auth_role`, `name`, `avatar`, `brief`, `sex`, `area`, `address`, `birthday`, `remark`, `last_login_at`, `last_login_ip`, `last_paid_at`, `last_paid_ip`, `consume_count`, `consume_amount`, `type`, `sort`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('1', '1', '0', 'admin', '', '', '', '$2y$13\$ZsldxLQuw/jaCSDQ76sRO.bISkCtjnniC2ijiV/wakkGaL4hmZhiK', '', '', 'funson86@gmail.com', '', '1', '', '', '', '0', '', '', '', '', '1605143153', '127.0.0.1', '0', '', '0', '0.00', '1', '50', '1', '1', '1606792873', '1', '2');
INSERT INTO `fb_user`(`id`, `store_id`, `parent_id`, `username`, `auth_key`, `token`, `access_token`, `password_hash`, `password_reset_token`, `verification_token`, `email`, `mobile`, `auth_role`, `name`, `avatar`, `brief`, `sex`, `area`, `address`, `birthday`, `remark`, `last_login_at`, `last_login_ip`, `last_paid_at`, `last_paid_ip`, `consume_count`, `consume_amount`, `type`, `sort`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('2', '2', '0', 'funpay', '', '', '', '$2y$13\$L58QDefrbiUjyxVXy6P/r.Mz9eeTjJpQEnk/hEN3pqZZRDiw4q7LC', '', '', 'funson86@gmail.com', '', '1', '', '', '', '0', '', '', '', '', '1607395941', '127.0.0.1', '0', '', '0', '0.00', '1', '50', '1', '1599808929', '1607395941', '1', '2');
INSERT INTO `fb_user`(`id`, `store_id`, `parent_id`, `username`, `auth_key`, `token`, `access_token`, `password_hash`, `password_reset_token`, `verification_token`, `email`, `mobile`, `auth_role`, `name`, `avatar`, `brief`, `sex`, `area`, `address`, `birthday`, `remark`, `last_login_at`, `last_login_ip`, `last_paid_at`, `last_paid_ip`, `consume_count`, `consume_amount`, `type`, `sort`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('3', '1', '0', 'test', '', '', '', '$2y$13\$ZsldxLQuw/jaCSDQ76sRO.bISkCtjnniC2ijiV/wakkGaL4hmZhiK', '', '', 'funson86@gmail.com', '', '1', '', '', '', '0', '', '', '', '', '1605143153', '127.0.0.1', '0', '', '0', '0.00', '1', '50', '1', '1', '1606792873', '1', '2');
INSERT INTO `fb_user`(`id`, `store_id`, `parent_id`, `username`, `auth_key`, `token`, `access_token`, `password_hash`, `password_reset_token`, `verification_token`, `email`, `mobile`, `auth_role`, `name`, `avatar`, `brief`, `sex`, `area`, `address`, `birthday`, `remark`, `last_login_at`, `last_login_ip`, `last_paid_at`, `last_paid_ip`, `consume_count`, `consume_amount`, `type`, `sort`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('4', '4', '0', 'funcms', '', '', '', '$2y$13\$ZsldxLQuw/jaCSDQ76sRO.bISkCtjnniC2ijiV/wakkGaL4hmZhiK', '', '', 'funson86@gmail.com', '', '1', '', '', '', '0', '', '', '', '', '1605143153', '127.0.0.1', '0', '', '0', '0.00', '1', '50', '1', '1', '1606792873', '1', '2');
INSERT INTO `fb_user`(`id`, `store_id`, `parent_id`, `username`, `auth_key`, `token`, `access_token`, `password_hash`, `password_reset_token`, `verification_token`, `email`, `mobile`, `auth_role`, `name`, `avatar`, `brief`, `sex`, `area`, `address`, `birthday`, `remark`, `last_login_at`, `last_login_ip`, `last_paid_at`, `last_paid_ip`, `consume_count`, `consume_amount`, `type`, `sort`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('5', '5', '0', 'funmall', '', '', '', '$2y$13\$ZsldxLQuw/jaCSDQ76sRO.bISkCtjnniC2ijiV/wakkGaL4hmZhiK', '', '', 'funson86@gmail.com', '', '1', '', '', '', '0', '', '', '', '', '1605143153', '127.0.0.1', '0', '', '0', '0.00', '1', '50', '1', '1', '1606792873', '1', '2');
INSERT INTO `fb_user`(`id`, `store_id`, `parent_id`, `username`, `auth_key`, `token`, `access_token`, `password_hash`, `password_reset_token`, `verification_token`, `email`, `mobile`, `auth_role`, `name`, `avatar`, `brief`, `sex`, `area`, `address`, `birthday`, `remark`, `last_login_at`, `last_login_ip`, `last_paid_at`, `last_paid_ip`, `consume_count`, `consume_amount`, `type`, `sort`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('6', '6', '0', 'funbbs', '', '', '', '$2y$13\$ZsldxLQuw/jaCSDQ76sRO.bISkCtjnniC2ijiV/wakkGaL4hmZhiK', '', '', 'funson86@gmail.com', '', '1', '', '', '', '0', '', '', '', '', '1605143153', '127.0.0.1', '0', '', '0', '0.00', '1', '50', '1', '1', '1606792873', '1', '2');

INSERT INTO `fb_base_message_type` VALUES ('7', '1', 'feedback', null, '0', '2', null, '7', '50', '1', '1', '1', '1', '1');

INSERT INTO `fb_base_dict` VALUES ('3', '1', '消息类型', 'message_type', '消息类型', '1', '50', '1', '1600778636', '1601181269', '1', '1');
INSERT INTO `fb_base_dict_data` VALUES ('9', '1', '3', '发给所有用户公告', '1', '公告', '发给所有用户公告', '1', '50', '1', '1601181323', '1601181323', '1', '1');
INSERT INTO `fb_base_dict_data` VALUES ('10', '1', '3', '定时提醒', '2', '提醒', '定时提醒', '1', '50', '1', '1601181586', '1601181586', '1', '1');
INSERT INTO `fb_base_dict_data` VALUES ('11', '1', '3', '私人信息', '3', '私信', '私人信息', '1', '50', '1', '1601181796', '1601181796', '1', '1');

INSERT INTO `fb_base_department` VALUES ('1', '1', '0', '技术部', 'backend', '技术部门', '1|2', '2|5', '1', '1', '50', '1', '1601024382', '1601032320', '1', '1');
INSERT INTO `fb_base_department` VALUES ('2', '1', '1', '后端开发组', 'backend', '', '', '', '1', '1', '50', '1', '1601024590', '1601030154', '1', '1');
INSERT INTO `fb_base_department` VALUES ('3', '1', '1', '前端开发组', 'backend', '', '', '', '1', '1', '50', '1', '1601030307', '1601030307', '1', '1');

INSERT INTO `fb_base_role` VALUES ('1', '1', 'superadmin', '0', 'Super Admin all permission, controller by programe', '', '60', '55', '1', '1599449404', '1603418473', '1', '1');
INSERT INTO `fb_base_role` VALUES ('2', '1', 'admin', '1', 'Normal admin', '', '60', '50', '1', '1599461439', '1603418493', '1', '1');
INSERT INTO `fb_base_role` VALUES ('3', '1', 'admin demo', '0', 'for view', '', '60', '50', '1', '1599461439', '1603418493', '1', '1');
INSERT INTO `fb_base_role` VALUES ('50', '1', 'store admin', '1', 'For Store Admin Login', '', '60', '50', '1', '1599710877', '1603418515', '1', '1');
INSERT INTO `fb_base_role` VALUES ('54', '1', 'store cms', '1', 'For Store Admin Login', '', '60', '50', '1', '1599710877', '1603418515', '1', '1');
INSERT INTO `fb_base_role` VALUES ('55', '1', 'store mall', '1', 'For Store Admin Login', '', '60', '50', '1', '1599710877', '1603418515', '1', '1');
INSERT INTO `fb_base_role` VALUES ('56', '1', 'store bbs', '1', 'For Store Admin Login', '', '60', '50', '1', '1599710877', '1603418515', '1', '1');
INSERT INTO `fb_base_role` VALUES ('100', '1', 'user frontend', '1', 'Frontend User', '', '60', '50', '1', '1599737332', '1602327113', '1', '1');


INSERT INTO `fb_base_permission` VALUES ('5', '1', '0', '管理系统', 'backend', '', '', 'fas fa-cog', '', '1', '0', '1', '50', '1', '1', '1599358085', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('6', '1', '0', '学校管理', 'backend', '', '', 'fas fa-laptop-house', '', '1', '0', '1', '50', '1', '1', '1599358085', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('56', '1', '5', '系统管理', 'backend', '', '', 'fas fa-cogs', '', '2', '0', '1', '50', '1', '1599358163', '1599358163', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('58', '1', '5', '系统监控', 'backend', '', '', 'fas fa-chart-bar', '', '2', '0', '1', '50', '1', '1599358315', '1599358315', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('61', '1', '6', '学生', 'backend', '', '', 'fas fa-users', '', '2', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('560', '1', '56', '用户管理', 'backend', '', '/base/user/index', 'fas fa-user', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('561', '1', '56', '店铺管理', 'backend', '', '/base/store/index', 'fab fa-internet-explorer', '', '3', '0', '1', '50', '1', '1', '1602322615', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('562', '1', '56', '部门管理', 'backend', '', '/base/department/index', 'fas fa-code-branch', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('563', '1', '56', '消息类型', 'backend', '', '/base/message-type/index', 'fas fa-envelope', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('564', '1', '56', '文件管理', 'backend', '', '/base/attachment/index', 'fas fa-folder', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('565', '1', '56', '角色权限管理', 'backend', '', '/base/role/index', 'fas fa-users', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('566', '1', '56', '菜单权限管理', 'backend', '', '/base/permission/index', 'fas fa-list', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('567', '1', '56', '系统配置', 'backend', '', '/base/setting/edit-all', 'fas fa-cog', '', '2', '0', '1', '50', '1', '1', '1600945413', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('568', '1', '56', '配置类型管理', 'backend', '', '/base/setting-type/index', 'fas fa-clipboard-check', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('569', '1', '56', '数据字典', 'backend', '', '/base/dict-data/index', 'fas fa-book', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('581', '1', '58', '日志管理', 'backend', '', '/base/log/index', 'fas fa-copy', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('583', '1', '58', '定时任务', 'backend', '', '/base/schedule/index', 'fas fa-clock', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('589', '1', '58', '系统信息', 'backend', '', '/system/index', 'fas fa-chart-area', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('611', '1', '61', '学生管理', 'backend', '', '/school/student/index', 'fas fa-users', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5601', '1', '560', '查看', 'backend', '', '/base/user/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5602', '1', '560', '编辑', 'backend', '', '/base/user/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5603', '1', '560', '删除', 'backend', '', '/base/user/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5604', '1', '560', '启禁', 'backend', '', '/base/user/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5605', '1', '560', '导出', 'backend', '', '/base/user/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5606', '1', '560', '导入', 'backend', '', '/base/user/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5611', '1', '561', '查看', 'backend', '', '/base/store/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5612', '1', '561', '编辑', 'backend', '', '/base/store/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5613', '1', '561', '删除', 'backend', '', '/base/store/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5614', '1', '561', '启禁', 'backend', '', '/base/store/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5615', '1', '561', '导出', 'backend', '', '/base/store/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5616', '1', '561', '导入', 'backend', '', '/base/store/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5621', '1', '562', '查看', 'backend', '', '/base/department/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5622', '1', '562', '编辑', 'backend', '', '/base/department/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5623', '1', '562', '删除', 'backend', '', '/base/department/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5624', '1', '562', '启禁', 'backend', '', '/base/department/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5625', '1', '562', '导出', 'backend', '', '/base/department/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5626', '1', '562', '导入', 'backend', '', '/base/department/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5631', '1', '563', '查看', 'backend', '', '/base/message-type/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5632', '1', '563', '编辑', 'backend', '', '/base/message-type/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5633', '1', '563', '删除', 'backend', '', '/base/message-type/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5634', '1', '563', '启禁', 'backend', '', '/base/message-type/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5635', '1', '563', '导出', 'backend', '', '/base/message-type/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5636', '1', '563', '导入', 'backend', '', '/base/message-type/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5641', '1', '564', '查看', 'backend', '', '/base/attachement/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5642', '1', '564', '编辑', 'backend', '', '/base/attachement/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5643', '1', '564', '删除', 'backend', '', '/base/attachement/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5644', '1', '564', '启禁', 'backend', '', '/base/attachement/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5645', '1', '564', '导出', 'backend', '', '/base/attachement/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5646', '1', '564', '导入', 'backend', '', '/base/attachement/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5651', '1', '565', '查看', 'backend', '', '/base/role/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5652', '1', '565', '编辑', 'backend', '', '/base/role/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5653', '1', '565', '删除', 'backend', '', '/base/role/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5654', '1', '565', '启禁', 'backend', '', '/base/role/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5655', '1', '565', '导出', 'backend', '', '/base/role/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5656', '1', '565', '导入', 'backend', '', '/base/role/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5661', '1', '566', '查看', 'backend', '', '/base/permission/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5662', '1', '566', '编辑', 'backend', '', '/base/permission/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5663', '1', '566', '删除', 'backend', '', '/base/permission/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5664', '1', '566', '启禁', 'backend', '', '/base/permission/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5665', '1', '566', '导出', 'backend', '', '/base/permission/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5666', '1', '566', '导入', 'backend', '', '/base/permission/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5671', '1', '567', '查看', 'backend', '', '/base/setting/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5672', '1', '567', '编辑', 'backend', '', '/base/setting/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5673', '1', '567', '删除', 'backend', '', '/base/setting/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5674', '1', '567', '启禁', 'backend', '', '/base/setting/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5675', '1', '567', '导出', 'backend', '', '/base/setting/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5676', '1', '567', '导入', 'backend', '', '/base/setting/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5681', '1', '568', '查看', 'backend', '', '/base/setting-type/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5682', '1', '568', '编辑', 'backend', '', '/base/setting-type/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5683', '1', '568', '删除', 'backend', '', '/base/setting-type/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5684', '1', '568', '启禁', 'backend', '', '/base/setting-type/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5685', '1', '568', '导出', 'backend', '', '/base/setting-type/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5686', '1', '568', '导入', 'backend', '', '/base/setting-type/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5691', '1', '569', '查看', 'backend', '', '/base/dict-data/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5692', '1', '569', '编辑', 'backend', '', '/base/dict-data/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5693', '1', '569', '删除', 'backend', '', '/base/dict-data/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5694', '1', '569', '启禁', 'backend', '', '/base/dict-data/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5695', '1', '569', '导出', 'backend', '', '/base/dict-data/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5696', '1', '569', '导入', 'backend', '', '/base/dict-data/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5811', '1', '581', '查看', 'backend', '', '/base/log/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5812', '1', '581', '编辑', 'backend', '', '/base/log/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5813', '1', '581', '删除', 'backend', '', '/base/log/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5814', '1', '581', '启禁', 'backend', '', '/base/log/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5815', '1', '581', '导出', 'backend', '', '/base/log/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5816', '1', '581', '导入', 'backend', '', '/base/log/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5817', '1', '581', '报表', 'backend', '', '/base/log/stat*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5831', '1', '583', '查看', 'backend', '', '/base/schedule/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5832', '1', '583', '编辑', 'backend', '', '/base/schedule/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5833', '1', '583', '删除', 'backend', '', '/base/schedule/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5834', '1', '583', '启禁', 'backend', '', '/base/schedule/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5835', '1', '583', '导出', 'backend', '', '/base/schedule/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5836', '1', '583', '导入', 'backend', '', '/base/schedule/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('6111', '1', '611', '查看', 'backend', '', '/base/student/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('6112', '1', '611', '编辑', 'backend', '', '/base/student/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('6113', '1', '611', '删除', 'backend', '', '/base/student/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('6114', '1', '611', '启禁', 'backend', '', '/base/student/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('6115', '1', '611', '导出', 'backend', '', '/base/student/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
-- INSERT INTO `fb_base_permission` VALUES ('6116', '1', '611', '导入', 'backend', '', '/base/student/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');


INSERT INTO `fb_base_role_permission` VALUES ('1', '1', '', '3', '5601', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('2', '1', '', '3', '560', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('3', '1', '', '3', '56', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('4', '1', '', '3', '5', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('5', '1', '', '3', '5611', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('6', '1', '', '3', '561', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('7', '1', '', '3', '5621', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('8', '1', '', '3', '562', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('9', '1', '', '3', '5631', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('10', '1', '', '3', '563', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('11', '1', '', '3', '5641', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('12', '1', '', '3', '564', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('13', '1', '', '3', '5651', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('14', '1', '', '3', '565', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('15', '1', '', '3', '5661', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('16', '1', '', '3', '566', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('17', '1', '', '3', '5671', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('18', '1', '', '3', '567', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('19', '1', '', '3', '5681', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('20', '1', '', '3', '568', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('21', '1', '', '3', '5691', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('22', '1', '', '3', '569', '1', '50', '1', '1607671710', '1607671710', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('23', '1', '', '3', '5811', '1', '50', '1', '1607671711', '1607671711', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('24', '1', '', '3', '581', '1', '50', '1', '1607671711', '1607671711', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('25', '1', '', '3', '58', '1', '50', '1', '1607671711', '1607671711', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('26', '1', '', '3', '5831', '1', '50', '1', '1607671711', '1607671711', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('27', '1', '', '3', '583', '1', '50', '1', '1607671711', '1607671711', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('28', '1', '', '3', '6111', '1', '50', '1', '1607671711', '1607671711', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('29', '1', '', '3', '611', '1', '50', '1', '1607671711', '1607671711', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('30', '1', '', '3', '61', '1', '50', '1', '1607671711', '1607671711', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('31', '1', '', '3', '6', '1', '50', '1', '1607671711', '1607671711', '1', '1');

INSERT INTO `fb_base_role_permission` VALUES ('128', '1', '', '50', '5', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('129', '1', '', '50', '6', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('130', '1', '', '50', '61', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('131', '1', '', '50', '560', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('132', '1', '', '50', '56', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('133', '1', '', '50', '562', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('134', '1', '', '50', '567', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('135', '1', '', '50', '611', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('136', '1', '', '50', '5601', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('137', '1', '', '50', '5602', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('138', '1', '', '50', '5603', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('139', '1', '', '50', '5604', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('140', '1', '', '50', '5605', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('141', '1', '', '50', '5606', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('142', '1', '', '50', '5621', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('143', '1', '', '50', '5622', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('144', '1', '', '50', '5623', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('145', '1', '', '50', '5624', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('146', '1', '', '50', '5625', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('147', '1', '', '50', '5626', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('148', '1', '', '50', '5671', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('149', '1', '', '50', '5672', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('150', '1', '', '50', '5673', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('151', '1', '', '50', '5674', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('152', '1', '', '50', '5675', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('153', '1', '', '50', '5676', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('154', '1', '', '50', '6111', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('155', '1', '', '50', '6112', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('156', '1', '', '50', '6113', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('157', '1', '', '50', '6114', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('158', '1', '', '50', '6115', '1', '50', '1', '1608030276', '1608030276', '1', '1');
-- INSERT INTO `fb_base_role_permission` VALUES ('159', '1', '', '50', '6116', '1', '50', '1', '1608030276', '1608030276', '1', '1');


INSERT INTO `fb_base_user_role` VALUES ('1', '2', '', '2', '50', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_user_role` VALUES ('2', '1', '', '3', '3', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_user_role` VALUES ('4', '4', '', '4', '50', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_user_role` VALUES ('5', '5', '', '5', '50', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_user_role` VALUES ('6', '6', '', '6', '50', '1', '50', '1', '1', '1', '1', '1');


INSERT INTO `fb_base_setting_type` VALUES ('50', '1', '0', 'backend', '网站设置', 'website', '', 7, 1, 'text', '', '', '50', '1', '1600948343', '1600948343', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('83', '1', '0', 'backend', '联系方式', 'contact', '', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('85', '1', '0', 'backend', '邮件设置', 'mail', '', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');

INSERT INTO `fb_base_setting_type` VALUES ('5001', '1', '50', 'backend', '网站标题', 'website_name', '', 7, 1, 'text', '', '', '50', '1', '1600948383', '1600948392', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5003', '1', '50', 'backend', '网站Logo', 'website_logo', '', 7, 1, 'image', '', '', '50', '1', '1600948430', '1600948430', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5005', '1', '50', 'backend', '网站favicon', 'website_favicon', '浏览器上小图标', 7, 1, 'image', '', '', '50', '1', '1600948430', '1600948430', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5007', '1', '50', 'backend', '网站banner', 'website_banner', 'Banner图', 7, 1, 'image', '', '', '50', '1', '1600948430', '1600948430', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5009', '1', '50', 'backend', 'SEO标题', 'website_seo_title', '浏览器标题栏便于搜索引擎收录', 7, 1, 'text', '', '', '50', '1', '1601008916', '1601008916', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5010', '1', '50', 'backend', 'SEO关键字', 'website_seo_keywords', '便于搜索引擎收录', 7, 1, 'text', '', '', '50', '1', '1601008916', '1601008916', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5011', '1', '50', 'backend', 'SEO描述', 'website_seo_description', '便于搜索引擎收录', 7, 1, 'text', '', '', '50', '1', '1601008916', '1601008916', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5013', '1', '50', 'backend', '主题模板', 'website_theme', '', 7, 1, 'dropDownList', 'green:green,black:black', '', '50', '1', '1600948430', '1600948430', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5015', '1', '50', 'backend', '网站通告', 'website_brief', '', 7, 1, 'text', '', '', '50', '1', '1600948430', '1600948430', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5017', '1', '50', 'backend', '版权标识', 'website_copyright', '', 7, 1, 'text', '', '@2020 - 版权所有', '50', '1', '1601003987', '1601003987', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5021', '1', '50', 'backend', '统计代码', 'website_stat', '加载在底部，支持百度统计cnzz等', 7, 1, 'textarea', '', '', '50', '1', '1601008532', '1601008544', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5023', '1', '50', 'backend', '地图代码', 'website_map', 'iframe方式', 7, 1, 'text', '', '', '50', '1', '1601008532', '1601008544', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('5031', '1', '50', 'backend', '注册用户需要验证邮箱才能登录', 'website_user_login_need_verify', '', 7, 1, 'radioList', '0:否,1:是', '0', '50', '1', '1601008532', '1601008544', '1', '1');

INSERT INTO `fb_base_setting_type` VALUES ('8301', '1', '83', 'backend', '电话', 'contact_mobile', '', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8303', '1', '83', 'backend', 'Email', 'contact_email', '', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8305', '1', '83', 'backend', '邮编', 'contact_zipcode', '', 7, 1, 'text', '计算距离算运费时非常重要', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8307', '1', '83', 'backend', '地址', 'contact_address', '', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');

INSERT INTO `fb_base_setting_type` VALUES ('8501', '1', '85', 'backend', 'Smtp Host', 'mail_smtp_host', '邮箱smtp主机地址，请申请outlook邮箱，并在设置中开启smtp，发送测试邮件后请在邮箱中确认', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8503', '1', '85', 'backend', 'Smtp Port', 'mail_smtp_port', '端口号', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8505', '1', '85', 'backend', 'Smtp Username', 'mail_smtp_username', '用户名', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8507', '1', '85', 'backend', 'Smtp Password', 'mail_smtp_password', '密码', 7, 1, 'text', '', '', '50', '1', '1600948360', '1600948360', '1', '1');
INSERT INTO `fb_base_setting_type` VALUES ('8509', '1', '85', 'backend', 'Smtp Encryption', 'mail_smtp_encryption', '加密方式', 7, 1, 'text', '', 'tls', '50', '1', '1600948360', '1600948360', '1', '1');

INSERT INTO `fb_base_schedule` VALUES ('1', '1', 'db/backup', '', '数据库备份，每天凌晨执行', '0 3 * * *', '1', '50', '1', '1600251253', '1602205031', '1', '1');
INSERT INTO `fb_base_schedule` VALUES ('2', '1', 'db/delete-log', '', '删除30天前日志，每天凌晨执行', '30 2 * * *', '1', '50', '1', '1600251253', '1602205031', '1', '1');

        ";

        //add user: admin  password: 123456
        $this->execute($sql);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
