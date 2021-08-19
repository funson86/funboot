<?php

use yii\db\Migration;

class m130524_201930_chat extends Migration
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

-- DROP TABLE IF EXISTS `fb_chat_room`;
-- CREATE TABLE `fb_chat_room` (
--   `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
--   `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
--   `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
--   `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '简介',
--   `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
--   `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
--   `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
--   `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
--   `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
--   `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
--   `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
--   PRIMARY KEY (`id`),
--   KEY `chat_room_k0` (`store_id`),
--   CONSTRAINT `chat_room_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
-- ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天室';

DROP TABLE IF EXISTS `fb_chat_log`;
CREATE TABLE `fb_chat_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `room_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '聊天室',
  `from_client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '发送用户',
  `to_client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '接收用户',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `content` text COMMENT '内容',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `chat_log_k0` (`store_id`),
  KEY `chat_log_k2` (`room_id`),
--  CONSTRAINT `chat_log_fk1` FOREIGN KEY (`room_id`) REFERENCES `fb_chat_room` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `chat_log_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天';

-- DROP TABLE IF EXISTS `fb_chat_message`;
-- CREATE TABLE `fb_chat_message` (
--   `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
--   `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
--   `from_user_id` bigint(20) unsigned NOT NULL COMMENT '发送用户',
--   `to_user_id` bigint(20) unsigned NOT NULL COMMENT '接收用户',
--   `content` text COMMENT '内容',
--   `read` int(11) NOT NULL DEFAULT '0' COMMENT '已读',
--   `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
--   `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
--   `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
--   `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
--   `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
--   `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
--   `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
--   PRIMARY KEY (`id`),
--   KEY `chat_message_k0` (`store_id`),
--   KEY `chat_message_k1` (`from_user`),
--   KEY `chat_message_k2` (`to_user`),
--   CONSTRAINT `chat_message_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
--   CONSTRAINT `chat_message_fk2` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
--   CONSTRAINT `chat_message_fk2` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
-- ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='私信';


        ";

        $this->execute($sql);
    }

    public function down()
    {
    }
}
