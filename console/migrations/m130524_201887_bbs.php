<?php

use yii\db\Migration;

class m130524_201887_bbs extends Migration
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
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简述',
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


-- ----------------------------
-- Table structure for fb_bbs_topic
-- ----------------------------
DROP TABLE IF EXISTS `fb_bbs_topic`;
CREATE TABLE `fb_bbs_topic` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `node_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '栏目',
  `name` varchar(255) NOT NULL COMMENT '标题',
  `thumb` json DEFAULT NULL COMMENT '缩略图',
  `images` json DEFAULT NULL COMMENT '图片集',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索优化标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索关键词',
  `seo_description` text COMMENT '搜索描述',
  `meta` json DEFAULT NULL COMMENT '参数',
  `brief` text COMMENT '简述',
  `content` text COMMENT '内容',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `template` varchar(255) NOT NULL DEFAULT 'topic' COMMENT '模板',
  `click` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `like` int(11) NOT NULL DEFAULT '0' COMMENT '点赞',
  `is_comment` varchar(255) NOT NULL DEFAULT 'list' COMMENT '允许评论',
  `type` varchar(255) NOT NULL DEFAULT 'list' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `bbs_topic_k1` (`node_id`),
  KEY `bbs_topic_k2` (`store_id`),
  CONSTRAINT `bbs_topic_fk1` FOREIGN KEY (`node_id`) REFERENCES `fb_bbs_node` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bbs_topic_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='话题';

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
  `like` int(11) NOT NULL DEFAULT '1' COMMENT '点赞',
  `ip` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'IP地址',
  `ip_info` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'IP信息',
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
  `target_type` int(11) NOT NULL DEFAULT '1' COMMENT '目标',
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
  `tag_ids` json DEFAULT NULL COMMENT '标签',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `brief` text COMMENT '简述',
  `content` text COMMENT '内容',
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
  CONSTRAINT `bbs_raw_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='原始数据';

        ";

        $this->execute($sql);


        $sql = "
SET FOREIGN_KEY_CHECKS=0;


INSERT INTO `fb_base_permission` VALUES ('53', '1', '5', 'BBS社区', 'backend', '', '', 'fas fa-comment-dots', '', '2', '0', '1', '50', '1', '1599358315', '1603847699', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('531', '1', '53', '话题管理', 'backend', '', '/bbs/topic/index', 'fas fa-file-alt', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('533', '1', '53', '评论管理', 'backend', '', '/bbs/comment/index', 'fas fa-comment-alt', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('535', '1', '53', '搜索记录', 'backend', '', '/bbs/search-log/index', 'fas fa-search', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
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
INSERT INTO `fb_base_permission` VALUES ('5351', '1', '535', '查看', 'backend', '', '/bbs/search-log/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5352', '1', '535', '编辑', 'backend', '', '/bbs/search-log/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5353', '1', '535', '删除', 'backend', '', '/bbs/search-log/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5354', '1', '535', '启禁', 'backend', '', '/bbs/search-log/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5355', '1', '535', '导出', 'backend', '', '/bbs/search-log/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5356', '1', '535', '导入', 'backend', '', '/bbs/search-log/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
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

INSERT INTO `fb_base_setting_type` VALUES (53, 1, 0, 'backend', 'Cms网站', 'bbs', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5311, 1, 53, 'backend', '主题', 'bbs_theme', '', 'text', '', 'default', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5312, 1, 53, 'backend', '模板', 'bbs_template', '', 'text', '', 'index', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5313, 1, 53, 'backend', '横幅', 'bbs_banner', '', 'images', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5314, 1, 53, 'backend', '横幅手机版', 'bbs_banner_h5', '', 'images', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5329, 1, 53, 'backend', '列表页默认每页数量', 'bbs_node_page_size', '', 'text', '', '12', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5343, 1, 53, 'backend', '关于我们', 'bbs_about_text', '', 'textarea', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5344, 1, 53, 'backend', '联系我们', 'bbs_contact_text', '', 'textarea', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5351, 1, 53, 'backend', '网站参数1', 'bbs_param1', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5352, 1, 53, 'backend', '网站参数2', 'bbs_param2', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5353, 1, 53, 'backend', '网站参数3', 'bbs_param3', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5354, 1, 53, 'backend', '网站参数4', 'bbs_param4', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5355, 1, 53, 'backend', '网站参数5', 'bbs_param5', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5356, 1, 53, 'backend', '网站参数6', 'bbs_param6', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5357, 1, 53, 'backend', '网站参数7', 'bbs_param7', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5358, 1, 53, 'backend', '网站参数8', 'bbs_param8', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (5359, 1, 53, 'backend', '网站参数9', 'bbs_param9', '', 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);


        ";

        //add user: admin  password: 123456
        $this->execute($sql);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
