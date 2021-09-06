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

SET FOREIGN_KEY_CHECKS=0;

INSERT INTO `fb_store` VALUES ('8', '0', '8', 'Funchat', 'Funchat', 'www.funchat.com', '', '', 'chat', '1634684399', 'Funchat', 32767, 'zh-CN', 32767, '', 32767, '', 32767, '', 0, 50, 1, 1, 1619169177, 1, 1);
INSERT INTO `fb_user`(`id`, `store_id`, `parent_id`, `username`, `auth_key`, `token`, `access_token`, `password_hash`, `password_reset_token`, `verification_token`, `email`, `mobile`, `auth_role`, `name`, `avatar`, `brief`, `sex`, `area`, `address`, `birthday`, `remark`, `last_login_at`, `last_login_ip`, `last_paid_at`, `last_paid_ip`, `consume_count`, `consume_amount`, `type`, `sort`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('8', '8', '0', 'funchat', '', '', '', '$2y$13\$ZsldxLQuw/jaCSDQ76sRO.bISkCtjnniC2ijiV/wakkGaL4hmZhiK', '', '', 'funson86@gmail.com', '', '1', '', '', '', '0', '', '', '', '', '1605143153', '127.0.0.1', '0', '', '0', '0.00', '1', '50', '1', '1', '1606792873', '1', '2');

INSERT INTO `fb_base_permission` VALUES ('59', '1', '5', '聊天室', 'backend', '', '', 'fas fa-comments', '', '2', '0', '1', '50', '1', '1599358315', '1599358315', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('597', '1', '59', '聊天记录', 'backend', '', '/chat/log/index', 'fas fa-chart-area', '', '3', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5971', '1', '597', '查看', 'backend', '', '/chat/log/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5972', '1', '597', '编辑', 'backend', '', '/chat/log/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5973', '1', '597', '删除', 'backend', '', '/chat/log/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5974', '1', '597', '启禁', 'backend', '', '/chat/log/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5975', '1', '597', '导出', 'backend', '', '/chat/log/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('5976', '1', '597', '导入', 'backend', '', '/chat/log/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');

INSERT INTO `fb_base_role_permission` VALUES ('5971', '1', '', '50', '59', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('5972', '1', '', '50', '597', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('5973', '1', '', '50', '5971', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('5974', '1', '', '50', '5972', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('5975', '1', '', '50', '5973', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('5976', '1', '', '50', '5974', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('5977', '1', '', '50', '5975', '1', '50', '1', '1608030276', '1608030276', '1', '1');
INSERT INTO `fb_base_role_permission` VALUES ('5978', '1', '', '50', '5976', '1', '50', '1', '1608030276', '1608030276', '1', '1');

        ";

        $this->execute($sql);
    }

    public function down()
    {
    }
}
