<?php

use yii\db\Migration;

class m130524_201889_bbs extends Migration
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

DROP TABLE IF EXISTS `fb_bbs_meta`;
CREATE TABLE `fb_bbs_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `brief` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_meta_k2` (`store_id`),
  CONSTRAINT `bbs_meta_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='参数';

DROP TABLE IF EXISTS `fb_bbs_node`;
CREATE TABLE `fb_bbs_node` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `surname` varchar(255) NOT NULL COMMENT '别名',
  `is_nav` int(11) NOT NULL DEFAULT '1' COMMENT '导航栏显示',
  `meta_id` int(11) NOT NULL DEFAULT '0' COMMENT '参数',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索优化标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索关键词',
  `seo_description` text COMMENT '搜索描述',
  `content` text COMMENT '内容',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `page_size` int(11) NOT NULL DEFAULT '24' COMMENT '分页数量',
  `template` varchar(255) NOT NULL DEFAULT 'node' COMMENT '模板',
  `template_topic` varchar(255) NOT NULL DEFAULT 'topic' COMMENT '详情页模板',
  `type` varchar(255) NOT NULL DEFAULT 'list' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_node_k2` (`store_id`),
  CONSTRAINT `bbs_node_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='栏目';

DROP TABLE IF EXISTS `fb_bbs_topic`;
CREATE TABLE `fb_bbs_topic` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `node_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '栏目',
  `tag_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '标签',
  `name` varchar(255) NOT NULL COMMENT '标题',
  `thumb` json DEFAULT NULL COMMENT '缩略图',
  `images` json DEFAULT NULL COMMENT '图片集',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索优化标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索关键词',
  `seo_description` text COMMENT '搜索描述',
  `meta` json DEFAULT NULL COMMENT '参数',
  `brief` text COMMENT '简述',
  `content` mediumtext COMMENT '内容',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `template` varchar(255) NOT NULL DEFAULT 'view' COMMENT '模板',
  `click` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `like` int(11) NOT NULL DEFAULT '0' COMMENT '点赞',
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT '评论',
  `is_comment` int(11) NOT NULL DEFAULT '1' COMMENT '允许评论',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT '种类',
  `kind` int(11) NOT NULL DEFAULT '0' COMMENT '特征',
  `grade` int(11) NOT NULL DEFAULT '0' COMMENT '等级',
  `format` int(11) NOT NULL DEFAULT '1' COMMENT '格式',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '作者',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '作者',
  `user_avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '作者头像',
  `last_comment_user_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '最后回复用户',
  `last_comment_username` varchar(255) NOT NULL DEFAULT '' COMMENT '最后回复用户名称',
  `last_comment_updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '最后回复时间',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_topic_k1` (`node_id`),
  KEY `bbs_topic_k2` (`store_id`),
  KEY `bbs_topic_k0` (`last_comment_updated_at`),
  KEY `bbs_topic_k3` (`click`),
  KEY `bbs_topic_k4` (`like`),
  KEY `bbs_topic_k5` (`user_id`),
  CONSTRAINT `bbs_topic_fk1` FOREIGN KEY (`node_id`) REFERENCES `fb_bbs_node` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_topic_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='话题';

-- ALTER TABLE `fb_bbs_topic` ADD COLUMN  `tag_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '标签' AFTER `node_id`;  

DROP TABLE IF EXISTS `fb_bbs_topic_meta`;
CREATE TABLE `fb_bbs_topic_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `topic_id` bigint(20) unsigned NOT NULL COMMENT '话题',
  `meta_id` bigint(20) unsigned NOT NULL COMMENT '参数',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `content` text COMMENT '内容',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_topic_meta_k2` (`store_id`),
  KEY `bbs_topic_meta_fk3` (`topic_id`),
  KEY `bbs_topic_meta_fk4` (`meta_id`),
  CONSTRAINT `bbs_topic_meta_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_topic_meta_fk3` FOREIGN KEY (`topic_id`) REFERENCES `fb_bbs_topic` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_topic_meta_fk4` FOREIGN KEY (`meta_id`) REFERENCES `fb_bbs_meta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='话题参数';

DROP TABLE IF EXISTS `fb_bbs_comment`;
CREATE TABLE `fb_bbs_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `topic_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '话题',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `like` int(11) NOT NULL DEFAULT '0' COMMENT '点赞',
  `ip` varchar(16) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `ip_info` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP信息',
  `type` varchar(255) NOT NULL DEFAULT 'list' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_comment_k0` (`user_id`),
  KEY `bbs_comment_k1` (`topic_id`),
  KEY `bbs_comment_k2` (`store_id`),
  CONSTRAINT `bbs_comment_fk0` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_comment_fk1` FOREIGN KEY (`topic_id`) REFERENCES `fb_bbs_topic` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_comment_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='评论';


DROP TABLE IF EXISTS `fb_bbs_tag`;
CREATE TABLE `fb_bbs_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `count` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_tag_k2` (`store_id`),
  CONSTRAINT `bbs_tag_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='标签';

DROP TABLE IF EXISTS `fb_bbs_topic_tag`;
CREATE TABLE `fb_bbs_topic_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `topic_id` bigint(20) unsigned NOT NULL COMMENT '话题',
  `tag_id` bigint(20) unsigned NOT NULL COMMENT '标签',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_topic_tag_fk2` (`store_id`),
  KEY `bbs_topic_tag_fk0` (`topic_id`),
  KEY `bbs_topic_tag_fk1` (`tag_id`),
  CONSTRAINT `bbs_topic_tag_fk0` FOREIGN KEY (`topic_id`) REFERENCES `fb_bbs_topic` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_topic_tag_fk1` FOREIGN KEY (`tag_id`) REFERENCES `fb_bbs_tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_topic_tag_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='话题标签';

DROP TABLE IF EXISTS `fb_bbs_user_action`;
CREATE TABLE `fb_bbs_user_action` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '标签',
  `target_id` bigint(20) unsigned NOT NULL COMMENT '目标ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `action` int(11) NOT NULL DEFAULT '1' COMMENT '动作',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_user_action_fk2` (`store_id`),
  KEY `bbs_user_action_fk1` (`user_id`),
  CONSTRAINT `bbs_user_action_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_user_action_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户行为';

DROP TABLE IF EXISTS `fb_bbs_search_log`;
CREATE TABLE `fb_bbs_search_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `session_id` varchar(255) NOT NULL DEFAULT '' COMMENT '会话ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_search_log_k2` (`store_id`),
  CONSTRAINT `bbs_search_log_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='搜索记录';

DROP TABLE IF EXISTS `fb_bbs_raw`;
CREATE TABLE `fb_bbs_raw` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `node_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '节点',
  `node_ids` json DEFAULT NULL COMMENT '额外节点',
  `node` varchar(255) NOT NULL DEFAULT '' COMMENT '分类',
  `tag_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '标签',
  `tag_ids` json DEFAULT NULL COMMENT '额外标签',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `brief` text COMMENT '简述',
  `content` text COMMENT '内容',
  `info` varchar(255) NOT NULL DEFAULT '' COMMENT '信息',
  `site` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_raw_k2` (`store_id`),
  KEY `bbs_raw_k3` (`created_at`) USING BTREE,
  KEY `bbs_raw_k4` (`url`) USING BTREE,
  CONSTRAINT `bbs_raw_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='原始数据';
        ";

        $this->execute($sql);


        $sql = "
SET FOREIGN_KEY_CHECKS=0;


INSERT INTO `fb_base_permission` VALUES ('53', '1', '5', 'BBS社区', 'backend', '', '', 'fas fa-comment-dots', '', '2', '0', '1', '50', '1', '1599358315', '1603847699', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('531', '1', '53', '话题管理', 'backend', '', '/bbs/topic/index', 'fas fa-file-alt', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('533', '1', '53', '评论管理', 'backend', '', '/bbs/comment/index', 'fas fa-comment-alt', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('535', '1', '53', '搜索记录', 'backend', '', '/base/search-log/index', 'fas fa-search', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('536', '1', '53', '标签管理', 'backend', '', '/bbs/tag/index', 'fas fa-tags', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('538', '1', '53', '栏目管理', 'backend', '', '/bbs/node/index', 'fas fa-list-ol', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('539', '1', '53', '参数管理', 'backend', '', '/bbs/meta/index', 'fas fa-list', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('5311', '1', '531', '查看', 'backend', '', '/bbs/topic/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5312', '1', '531', '编辑', 'backend', '', '/bbs/topic/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5313', '1', '531', '删除', 'backend', '', '/bbs/topic/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5314', '1', '531', '启禁', 'backend', '', '/bbs/topic/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5315', '1', '531', '导出', 'backend', '', '/bbs/topic/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5316', '1', '531', '导入', 'backend', '', '/bbs/topic/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5331', '1', '533', '查看', 'backend', '', '/bbs/comment/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5332', '1', '533', '编辑', 'backend', '', '/bbs/comment/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5333', '1', '533', '删除', 'backend', '', '/bbs/comment/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5334', '1', '533', '启禁', 'backend', '', '/bbs/comment/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5335', '1', '533', '导出', 'backend', '', '/bbs/comment/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5336', '1', '533', '导入', 'backend', '', '/bbs/comment/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5351', '1', '535', '查看', 'backend', '', '/base/search-log/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5352', '1', '535', '编辑', 'backend', '', '/base/search-log/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5353', '1', '535', '删除', 'backend', '', '/base/search-log/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5354', '1', '535', '启禁', 'backend', '', '/base/search-log/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5355', '1', '535', '导出', 'backend', '', '/base/search-log/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5356', '1', '535', '导入', 'backend', '', '/base/search-log/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5361', '1', '536', '查看', 'backend', '', '/bbs/tag/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5362', '1', '536', '编辑', 'backend', '', '/bbs/tag/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5363', '1', '536', '删除', 'backend', '', '/bbs/tag/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5364', '1', '536', '启禁', 'backend', '', '/bbs/tag/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5365', '1', '536', '导出', 'backend', '', '/bbs/tag/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5366', '1', '536', '导入', 'backend', '', '/bbs/tag/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5381', '1', '538', '查看', 'backend', '', '/bbs/comment/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5382', '1', '538', '编辑', 'backend', '', '/bbs/comment/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5383', '1', '538', '删除', 'backend', '', '/bbs/comment/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5384', '1', '538', '启禁', 'backend', '', '/bbs/comment/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5385', '1', '538', '导出', 'backend', '', '/bbs/comment/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5386', '1', '538', '导入', 'backend', '', '/bbs/comment/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5391', '1', '539', '查看', 'backend', '', '/bbs/meta/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5392', '1', '539', '编辑', 'backend', '', '/bbs/meta/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5393', '1', '539', '删除', 'backend', '', '/bbs/meta/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5394', '1', '539', '启禁', 'backend', '', '/bbs/meta/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5395', '1', '539', '导出', 'backend', '', '/bbs/meta/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5396', '1', '539', '导入', 'backend', '', '/bbs/meta/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');

INSERT INTO `fb_base_setting_type` VALUES (53, 1, 0, 'backend', 'BBS社区', 'bbs', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5311, 1, 53, 'backend', '主题', 'bbs_theme', '', 'text', '', 'default', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5313, 1, 53, 'backend', '主页模板', 'bbs_template', '', 'text', '', 'index', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5320, 1, 53, 'backend', '列表页默认每页数量', 'bbs_node_page_size', '', 'text', '', '24', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5341, 1, 53, 'backend', '关于我们', 'bbs_about_text', '', 'textarea', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5343, 1, 53, 'backend', '联系我们', 'bbs_contact_text', '', 'textarea', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5381, 1, 53, 'backend', '网站参数1', 'bbs_param1', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5382, 1, 53, 'backend', '网站参数2', 'bbs_param2', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5383, 1, 53, 'backend', '网站参数3', 'bbs_param3', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5384, 1, 53, 'backend', '网站参数4', 'bbs_param4', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5385, 1, 53, 'backend', '网站参数5', 'bbs_param5', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5386, 1, 53, 'backend', '网站参数6', 'bbs_param6', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5387, 1, 53, 'backend', '网站参数7', 'bbs_param7', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5388, 1, 53, 'backend', '网站参数8', 'bbs_param8', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5389, 1, 53, 'backend', '网站参数9', 'bbs_param9', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);

INSERT INTO `fb_base_role_permission` VALUES ('421', '1', '', '50', '53', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('422', '1', '', '50', '531', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('423', '1', '', '50', '533', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('425', '1', '', '50', '535', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('426', '1', '', '50', '536', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('428', '1', '', '50', '538', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('429', '1', '', '50', '539', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('433', '1', '', '50', '5311', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('434', '1', '', '50', '5312', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('435', '1', '', '50', '5313', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('436', '1', '', '50', '5314', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('437', '1', '', '50', '5315', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('438', '1', '', '50', '5316', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('443', '1', '', '50', '5331', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('444', '1', '', '50', '5332', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('445', '1', '', '50', '5333', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('446', '1', '', '50', '5334', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('447', '1', '', '50', '5335', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('448', '1', '', '50', '5336', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('453', '1', '', '50', '5351', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('454', '1', '', '50', '5352', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('455', '1', '', '50', '5353', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('456', '1', '', '50', '5354', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('457', '1', '', '50', '5355', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('458', '1', '', '50', '5356', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('463', '1', '', '50', '5361', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('464', '1', '', '50', '5362', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('465', '1', '', '50', '5363', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('466', '1', '', '50', '5364', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('467', '1', '', '50', '5365', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('468', '1', '', '50', '5366', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('483', '1', '', '50', '5381', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('484', '1', '', '50', '5382', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('485', '1', '', '50', '5383', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('486', '1', '', '50', '5384', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('487', '1', '', '50', '5385', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('488', '1', '', '50', '5386', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('493', '1', '', '50', '5391', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('494', '1', '', '50', '5392', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('495', '1', '', '50', '5393', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('496', '1', '', '50', '5394', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('497', '1', '', '50', '5395', '1', '50', '1', '1602505044', '1606818825', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('498', '1', '', '50', '5396', '1', '50', '1', '1602505044', '1606818825', '1', '1');

update fb_bbs_topic set `name` = replace(`name`, '餐饮信息汇总', '英国餐饮信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '伦敦英国餐饮信息汇总', '伦敦餐饮信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '伯明翰英国餐饮信息汇总', '伯明翰餐饮信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '曼彻斯特英国餐饮信息汇总', '曼彻斯特餐饮信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '格拉斯哥英国餐饮信息汇总', '格拉斯哥餐饮信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '卡迪夫英国餐饮信息汇总', '卡迪夫餐饮信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '贝尔法斯特英国餐饮信息汇总', '贝尔法斯特餐饮信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '社区信息汇总', '英国社区信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '伦敦英国社区信息汇总', '伦敦社区信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '伯明翰英国社区信息汇总', '伯明翰社区信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '曼彻斯特英国社区信息汇总', '曼彻斯特社区信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '格拉斯哥英国社区信息汇总', '格拉斯哥社区信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '卡迪夫英国社区信息汇总', '卡迪夫社区信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '贝尔法斯特英国社区信息汇总', '贝尔法斯特社区信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '生活信息汇总', '英国生活信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '伦敦英国生活信息汇总', '伦敦生活信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '伯明翰英国生活信息汇总', '伯明翰生活信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '曼彻斯特英国生活信息汇总', '曼彻斯特生活信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '格拉斯哥英国生活信息汇总', '格拉斯哥生活信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '卡迪夫英国生活信息汇总', '卡迪夫生活信息汇总');
update fb_bbs_topic set `name` = replace(`name`, '贝尔法斯特英国生活信息汇总', '贝尔法斯特生活信息汇总');

update fb_bbs_topic set tag_id = 101 where `name` like '%伦敦%';
update fb_bbs_topic set tag_id = 102 where `name` like '%伯明翰%';
update fb_bbs_topic set tag_id = 103 where `name` like '%曼彻斯特%';
update fb_bbs_topic set tag_id = 106 where `name` like '%格拉斯哥%';
update fb_bbs_topic set tag_id = 107 where `name` like '%卡迪夫%';
update fb_bbs_topic set tag_id = 108 where `name` like '%贝尔法斯特%';
        ";

        //add user: admin  password: 123456
        $this->execute($sql);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
