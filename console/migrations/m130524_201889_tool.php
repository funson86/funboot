<?php

use yii\db\Migration;

class m130524_201889_tool extends Migration
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

DROP TABLE IF EXISTS `fb_tool_crud`;
CREATE TABLE `fb_tool_crud` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `time` varchar(255) NOT NULL DEFAULT '' COMMENT '时间',
  `date` varchar(255) NOT NULL DEFAULT '' COMMENT '日期',
  `started_at` varchar(255) NOT NULL DEFAULT '' COMMENT '开始时间',
  `ended_at` varchar(255) NOT NULL DEFAULT '' COMMENT '开始时间',
  `tag` varchar(255) NOT NULL DEFAULT '' COMMENT '标签',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '多图',
  `file` varchar(255) NOT NULL DEFAULT '' COMMENT '文件',
  `files` varchar(255) NOT NULL DEFAULT '' COMMENT '多文件',
  `markdown` text COMMENT 'Markdown编辑器',
  `content` text COMMENT '内容',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT 50 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` int(11) NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` int(11) NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `tool_crud_fk2` (`store_id`),
  CONSTRAINT `tool_crud_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT 'Crud';

        ";

        $this->execute($sql);


        //add user: admin  password: 123456
        $sql = "
SET FOREIGN_KEY_CHECKS=0;


        ";

        //add user: admin  password: 123456
        $this->execute($sql);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
