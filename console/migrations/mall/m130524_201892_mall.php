<?php

use yii\db\Migration;

class m130524_201892_mall extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 ENGINE=InnoDB';
        }

        $sql = "
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `fb_mall_address`;
CREATE TABLE `fb_mall_address` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '用户',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `first_name` varchar(255) NOT NULL DEFAULT '' COMMENT '名字',
  `last_name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓氏',
  `country_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '国家',
  `country` varchar(255) NOT NULL DEFAULT '' COMMENT '国家',
  `province_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '省',
  `province` varchar(255) NOT NULL DEFAULT '' COMMENT '省',
  `city_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '市',
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '市',
  `district_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `district` varchar(255) NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `address2` varchar(255) NOT NULL DEFAULT '' COMMENT '地址2',
  `postcode` varchar(255) NOT NULL DEFAULT '' COMMENT '邮编',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '默认地址',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_address_k1` (`user_id`),
  KEY `mall_address_k2` (`store_id`),
  CONSTRAINT `mall_address_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_address_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地址';

DROP TABLE IF EXISTS `fb_mall_brand`;
CREATE TABLE `fb_mall_brand` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'Logo',
  `brief` text comment '简介',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_brand_k2` (`store_id`),
  CONSTRAINT `mall_brand_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='品牌';

DROP TABLE IF EXISTS `fb_mall_vendor`;
CREATE TABLE `fb_mall_vendor` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `consignee` varchar(255) NOT NULL DEFAULT '' COMMENT '联系人',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `brief` text comment '简介',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_vendor_k2` (`store_id`),
  CONSTRAINT `mall_vendor_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='供应商';

DROP TABLE IF EXISTS `fb_mall_tag`;
CREATE TABLE `fb_mall_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_tag_k2` (`store_id`),
  CONSTRAINT `mall_tag_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='标签';

DROP TABLE IF EXISTS `fb_mall_category`;
CREATE TABLE `fb_mall_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `brief` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `is_nav` int(11) NOT NULL DEFAULT '1' COMMENT '导航栏显示',
  `banner` varchar(255) NOT NULL DEFAULT '' COMMENT '封面图',
  `seo_url` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索优化Url',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索优化标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索关键词',
  `seo_description` text COMMENT '搜索描述',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_category_k2` (`store_id`),
  CONSTRAINT `mall_category_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分类';

DROP TABLE IF EXISTS `fb_mall_attribute`;
CREATE TABLE `fb_mall_attribute` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
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
  KEY `mall_attribute_k2` (`store_id`),
  CONSTRAINT `mall_attribute_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='属性';

DROP TABLE IF EXISTS `fb_mall_attribute_item`;
CREATE TABLE `fb_mall_attribute_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `attribute_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '属性',
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
  KEY `mall_attribute_item_k0` (`store_id`),
  KEY `mall_attribute_item_k2` (`attribute_id`),
  CONSTRAINT `mall_attribute_item_fk1` FOREIGN KEY (`attribute_id`) REFERENCES `fb_mall_attribute` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_attribute_item_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='属性项';

DROP TABLE IF EXISTS `fb_mall_attribute_set`;
CREATE TABLE `fb_mall_attribute_set` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
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
  KEY `mall_attribute_set_k2` (`store_id`),
  CONSTRAINT `mall_attribute_set_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='属性集';

DROP TABLE IF EXISTS `fb_mall_attribute_set_attribute`;
CREATE TABLE `fb_mall_attribute_set_attribute` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `attribute_set_id` bigint(20) unsigned NOT NULL COMMENT '属性集',
  `attribute_id` bigint(20) unsigned NOT NULL COMMENT '属性',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_attribute_set_attribute_k1` (`attribute_set_id`),
  KEY `mall_attribute_set_attribute_k2` (`store_id`),
  CONSTRAINT `mall_attribute_set_attribute_fk0` FOREIGN KEY (`attribute_set_id`) REFERENCES `fb_mall_attribute_set` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_attribute_set_attribute_fk1` FOREIGN KEY (`attribute_id`) REFERENCES `fb_mall_attribute` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_attribute_set_attribute_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='属性集属性关系';

DROP TABLE IF EXISTS `fb_mall_product`;
CREATE TABLE `fb_mall_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `category_id` bigint(20) unsigned NOT NULL COMMENT '分类',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `sku` varchar(255) NOT NULL COMMENT '库存编号',
  `stock_code` varchar(255) NOT NULL DEFAULT '' COMMENT '仓库条码',
  `stock` int(11) NOT NULL DEFAULT '99999' COMMENT '库存数量',
  `stock_warning` int(11) NOT NULL DEFAULT '99999' COMMENT '库存预警',
  `weight` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '重量',
  `volume` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '体积',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `wholesale_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '拼团价',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `images` json DEFAULT NULL COMMENT '图集',
  `tags` json NULL COMMENT '标签',
  `brief` text COMMENT '简介',
  `content` text COMMENT '内容',
  `seo_url` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索优化Url',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索优化标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索关键词',
  `seo_description` text COMMENT '搜索描述',
  `brand_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '品牌',
  `vendor_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '供应商',
  `attribute_set_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '属性集',
  `param_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '参数',
  `star` decimal(11,2) NOT NULL DEFAULT '5.00' COMMENT '星级',
  `reviews` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
  `sales` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `click` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_product_k2` (`store_id`),
  KEY `mall_product_k3` (`category_id`),
  KEY `mall_product_k4` (`price`),
  KEY `mall_product_k5` (`click`),
  KEY `mall_product_k6` (`star`),
  KEY `mall_product_k7` (`sort`),
  CONSTRAINT `mall_product_fk1` FOREIGN KEY (`category_id`) REFERENCES `fb_mall_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_product_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品';

DROP TABLE IF EXISTS `fb_mall_product_sku`;
CREATE TABLE `fb_mall_product_sku` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `product_id` bigint(20) unsigned NOT NULL COMMENT '商品',
  `attribute_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `wholesale_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '拼团价',
  `sku` varchar(255) NOT NULL COMMENT '库存编号',
  `stock_code` varchar(255) NOT NULL DEFAULT '' COMMENT '仓库条码',
  `stock` int(11) NOT NULL DEFAULT '99999' COMMENT '库存数量',
  `weight` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '重量',
  `volume` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '体积',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_product_sku_k2` (`store_id`),
  KEY `mall_product_sku_k0` (`product_id`),
  CONSTRAINT `mall_product_sku_fk0` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_product_sku_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品属性SKU';

DROP TABLE IF EXISTS `fb_mall_product_attribute_item_label`;
CREATE TABLE `fb_mall_product_attribute_item_label` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `product_id` bigint(20) unsigned NOT NULL COMMENT '商品',
  `attribute_item_id` bigint(20) unsigned NOT NULL COMMENT '属性项',
  `label` varchar(255) NOT NULL DEFAULT '' COMMENT '标签',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_product_attribute_item_label_k0` (`store_id`),
  KEY `mall_product_attribute_item_label_k1` (`product_id`),
  KEY `mall_product_attribute_item_label_k3` (`attribute_item_id`),
  CONSTRAINT `mall_product_attribute_item_label_fk0` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_product_attribute_item_label_fk3` FOREIGN KEY (`attribute_item_id`) REFERENCES `fb_mall_attribute_item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_product_attribute_item_label_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品属性项标签';

DROP TABLE IF EXISTS `fb_mall_product_tag`;
CREATE TABLE `fb_mall_product_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `product_id` bigint(20) unsigned NOT NULL COMMENT '商品',
  `tag_id` bigint(20) unsigned NOT NULL COMMENT '标签',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_product_tag_k2` (`store_id`),
  KEY `mall_product_tag_k0` (`product_id`),
  KEY `mall_product_tag_k1` (`tag_id`),
  CONSTRAINT `mall_product_tag_fk0` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_product_tag_fk1` FOREIGN KEY (`tag_id`) REFERENCES `fb_mall_tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_product_tag_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品标签';

DROP TABLE IF EXISTS `fb_mall_cart`;
CREATE TABLE `fb_mall_cart` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `session_id` varchar(255) NOT NULL DEFAULT '' COMMENT '会话ID',
  `product_id` bigint(20) unsigned NOT NULL COMMENT '商品',
  `product_attribute_value` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `sku` varchar(255) NOT NULL COMMENT '库存编码',
  `number` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `wholesale_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '拼团价',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_cart_k2` (`store_id`),
  KEY `mall_cart_k1` (`product_id`),
  CONSTRAINT `mall_cart_fk1` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_cart_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='购物车';


DROP TABLE IF EXISTS `fb_mall_review`;
CREATE TABLE `fb_mall_review` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `product_id` bigint(20) unsigned NOT NULL COMMENT '商品',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单',
  `star` int(11) NOT NULL DEFAULT 5 COMMENT '星级',
  `content` text COMMENT '内容',
  `point` int(11) NOT NULL DEFAULT 0 COMMENT '赠送积分',
  `like` int(11) NOT NULL DEFAULT 0 COMMENT '点赞',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_review_k2` (`store_id`),
  KEY `mall_review_k1` (`product_id`),
  KEY `mall_review_k0` (`user_id`),
  CONSTRAINT `mall_review_fk0` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_review_fk1` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_review_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='评价';


DROP TABLE IF EXISTS `fb_mall_consultation`;
CREATE TABLE `fb_mall_consultation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `product_id` bigint(20) unsigned NOT NULL COMMENT '商品',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `question` text COMMENT '咨询',
  `answer` text COMMENT '回答',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_consultation_k2` (`store_id`),
  KEY `mall_consultation_k1` (`product_id`),
  CONSTRAINT `mall_consultation_fk1` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_consultation_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='购买咨询';

DROP TABLE IF EXISTS `fb_mall_favorite`;
CREATE TABLE `fb_mall_favorite` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商品',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_favorite_k2` (`store_id`),
  KEY `mall_favorite_k0` (`user_id`),
  KEY `mall_favorite_k1` (`product_id`),
  CONSTRAINT `mall_favorite_fk0` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_favorite_fk1` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_favorite_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='收藏';

DROP TABLE IF EXISTS `fb_mall_coupon_type`;
CREATE TABLE `fb_mall_coupon_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `money` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '优惠金额',
  `min_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低金额',
  `started_at` int(11) NOT NULL COMMENT '开始时间',
  `ended_at` int(11) NOT NULL COMMENT '结束时间',
  `sn` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_coupon_type_k2` (`store_id`),
  CONSTRAINT `mall_coupon_type_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='优惠券类型';

DROP TABLE IF EXISTS `fb_mall_coupon`;
CREATE TABLE `fb_mall_coupon` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `coupon_type_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '优惠券类型',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `money` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '优惠金额',
  `min_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低金额',
  `started_at` int(11) NOT NULL COMMENT '开始时间',
  `ended_at` int(11) NOT NULL COMMENT '结束时间',
  `min_product_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低商品总额',
  `sn` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `order_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单',
  `used_at` int(11) NOT NULL DEFAULT '0' COMMENT '使用时间',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_coupon_k0` (`store_id`),
  KEY `mall_coupon_k1` (`user_id`),
  KEY `mall_coupon_k2` (`coupon_type_id`),
  CONSTRAINT `mall_coupon_fk0` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_coupon_fk1` FOREIGN KEY (`coupon_type_id`) REFERENCES `fb_mall_coupon_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_coupon_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='优惠券';


DROP TABLE IF EXISTS `fb_mall_order`;
CREATE TABLE `fb_mall_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `address_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '地址ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `sn` varchar(255) NOT NULL COMMENT '编号',
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名字',
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓氏',
  `country_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '国家',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '国家',
  `province_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '省',
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '省',
  `city_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '市',
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '市',
  `district_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址2',
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮编',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `distance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '距离',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `payment_method` int(11) NOT NULL DEFAULT '1' COMMENT '支付方式',
  `payment_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付手续费',
  `payment_status` int(11) NOT NULL DEFAULT '20' COMMENT '支付状态',
  `paid_at` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `shipment_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送公司',
  `shipment_name` varchar(255) NOT NULL DEFAULT '' COMMENT '配送名称',
  `shipment_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送费',
  `shipment_status` int(11) NOT NULL DEFAULT '60' COMMENT '配送状态',
  `shipped_at` int(11) NOT NULL DEFAULT '0' COMMENT '配送时间',
  `product_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `extra_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '额外费用',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
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
  KEY `mall_order_k2` (`store_id`),
  KEY `mall_order_k3` (`user_id`),
  CONSTRAINT `mall_order_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_order_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单';

DROP TABLE IF EXISTS `fb_mall_order_product`;
CREATE TABLE `fb_mall_order_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父节点',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `order_id` bigint(20) unsigned NOT NULL COMMENT '订单',
  `product_id` bigint(20) unsigned NOT NULL COMMENT '商品',
  `product_attribute_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `sku` varchar(255) NOT NULL COMMENT '库存编码',
  `number` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `wholesale_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '拼团价',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `cart_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '购物车ID',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_order_product_k0` (`store_id`),
  KEY `mall_order_product_k1` (`user_id`),
  KEY `mall_order_product_k3` (`order_id`),
  KEY `mall_order_product_k4` (`product_id`),
  CONSTRAINT `mall_order_product_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_order_product_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_order_product_fk3` FOREIGN KEY (`order_id`) REFERENCES `fb_mall_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_order_product_fk4` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单商品';

DROP TABLE IF EXISTS `fb_mall_param`;
CREATE TABLE `fb_mall_param` (
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
  KEY `mall_param_k2` (`store_id`),
  CONSTRAINT `mall_param_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='规格参数';

DROP TABLE IF EXISTS `fb_mall_product_param`;
CREATE TABLE `fb_mall_product_param` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `product_id` bigint(20) unsigned NOT NULL COMMENT '商品',
  `param_id` bigint(20) unsigned NOT NULL COMMENT '参数',
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
  KEY `mall_product_param_k2` (`store_id`),
  KEY `mall_product_param_k3` (`product_id`),
  KEY `mall_product_param_k4` (`param_id`),
  CONSTRAINT `mall_product_param_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_product_param_fk3` FOREIGN KEY (`product_id`) REFERENCES `fb_mall_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_product_param_fk4` FOREIGN KEY (`param_id`) REFERENCES `fb_mall_param` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品参数';

DROP TABLE IF EXISTS `fb_mall_refund`;
CREATE TABLE `fb_mall_refund` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `order_id` bigint(20) unsigned NOT NULL COMMENT '订单',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `brief` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
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
  KEY `mall_refund_k0` (`order_id`),
  KEY `mall_refund_k1` (`user_id`),
  KEY `mall_refund_k2` (`store_id`),
  CONSTRAINT `mall_refund_fk0` FOREIGN KEY (`order_id`) REFERENCES `fb_mall_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_refund_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_refund_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='退款';

DROP TABLE IF EXISTS `fb_mall_invoice`;
CREATE TABLE `fb_mall_invoice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `order_id` bigint(20) unsigned NOT NULL COMMENT '订单',
  `name` varchar(255) NOT NULL COMMENT '名称',
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
  KEY `mall_invoice_k0` (`order_id`),
  KEY `mall_invoice_k1` (`user_id`),
  KEY `mall_invoice_k2` (`store_id`),
  CONSTRAINT `mall_invoice_fk0` FOREIGN KEY (`order_id`) REFERENCES `fb_mall_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_invoice_fk1` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_invoice_fk2` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='发票';

DROP TABLE IF EXISTS `fb_mall_order_log`;
CREATE TABLE `fb_mall_order_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `order_id` bigint(20) unsigned NOT NULL COMMENT '订单',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_order_log_k0` (`store_id`),
  KEY `mall_order_log_k1` (`order_id`),
  CONSTRAINT `mall_order_log_fk1` FOREIGN KEY (`order_id`) REFERENCES `fb_mall_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_order_log_fk2` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_order_log_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单记录';

DROP TABLE IF EXISTS `fb_mall_point_log`;
CREATE TABLE `fb_mall_point_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '商家',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `original` int(11) NOT NULL DEFAULT '0' COMMENT '原值',
  `balance` int(11) NOT NULL DEFAULT '0' COMMENT '余额',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '1' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '1' COMMENT '更新时间',
  `created_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '创建用户',
  `updated_by` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '更新用户',
  PRIMARY KEY (`id`),
  KEY `mall_point_log_k0` (`store_id`),
  KEY `mall_point_log_k1` (`user_id`),
  CONSTRAINT `mall_point_log_fk2` FOREIGN KEY (`user_id`) REFERENCES `fb_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mall_point_log_fk0` FOREIGN KEY (`store_id`) REFERENCES `fb_store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='积分记录';

SET FOREIGN_KEY_CHECKS=1;

-- ALTER TABLE `fb_mall_brand` change `description` `brief` text COMMENT '简介';  
-- ALTER TABLE `fb_mall_vendor` change `description` `brief` text COMMENT '简介';  
-- ALTER TABLE `fb_mall_attribute_item` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_mall_attribute_set` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_mall_param` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_mall_refund` change `description` `brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简介';  
-- ALTER TABLE `fb_mall_category` add `seo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '搜索优化Url' after `banner`;
-- ALTER TABLE `fb_mall_product` add `seo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '搜索优化Url' after `content`;
-- ALTER TABLE `fb_mall_product` add `reviews` int(11) NOT NULL DEFAULT '0' COMMENT '评论数' after `star`;

        ";

        $this->execute($sql);


        $sql = "
SET FOREIGN_KEY_CHECKS=0;

INSERT INTO `fb_base_permission` VALUES (2, 1, 0, '商城', 'backend', '', '', 'fas fa-shopping-bag', '', 1, 0, 1, 50, 1, 1, 1599358085, 1, 1);

INSERT INTO `fb_base_permission` VALUES ('21', '1', '2', '订单管理', 'backend', '', '', 'fas fa-copy', '', '2', '0', '1', '50', '1', '1599358315', '1603847699', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('22', '1', '2', '运营管理', 'backend', '', '', 'fas fa-chart-line', '', '2', '0', '1', '50', '1', '1599358315', '1603847699', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('24', '1', '2', '商品管理', 'backend', '', '', 'fas fa-box-open', '', '2', '0', '1', '50', '1', '1599358315', '1603847699', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('25', '1', '2', '商品配置', 'backend', '', '', 'fas fa-sliders-h', '', '2', '0', '1', '50', '1', '1599358315', '1603847699', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('27', '1', '2', '促销管理', 'backend', '', '', 'fas fa-gift', '', '2', '0', '1', '50', '1', '1599358315', '1603847699', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('210', '1', '21', '订单列表', 'backend', '', '/mall/order/index', 'far fa-copy', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('213', '1', '21', '发票管理', 'backend', '', '/mall/invoice/index', 'fas fa-receipt', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('215', '1', '21', '退款管理', 'backend', '', '/mall/refund/index', 'fas fa-hand-holding-usd', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('217', '1', '21', '购物车', 'backend', '', '/mall/cart/index', 'fas fa-shopping-cart', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('224', '1', '22', '搜索记录', 'backend', '', '/base/search-log/index', 'fas fa-search-plus', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('226', '1', '22', '用户地址', 'backend', '', '/mall/address/index', 'fas fa-map-marker-alt', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('240', '1', '24', '商品列表', 'backend', '', '/mall/product/index', 'fas fa-box', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('243', '1', '24', '商品评价', 'backend', '', '/mall/review/index', 'fas fa-thumbs-up', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('244', '1', '24', '购买咨询', 'backend', '', '/mall/consultation/index', 'fas fa-comments', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('245', '1', '24', '商品收藏', 'backend', '', '/mall/favorite/index', 'fas fa-heart', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('248', '1', '24', '分类管理', 'backend', '', '/mall/category/index', 'fas fa-bars', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('251', '1', '25', '商品属性集', 'backend', '', '/mall/attribute-set/index', 'fas fa-list', '', '3', '0', '1', '50', '1', '1599358315', '1603847794', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('252', '1', '25', '商品属性', 'backend', '', '/mall/attribute/index', 'fas fa-list-alt', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('253', '1', '25', '商品属性项', 'backend', '', '/mall/attribute-item/index', 'far fa-list-alt', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('255', '1', '25', '商品参数', 'backend', '', '/mall/param/index', 'fas fa-list-ol', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('256', '1', '25', '标签管理', 'backend', '', '/mall/tag/index', 'fas fa-tags', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('257', '1', '25', '品牌管理', 'backend', '', '/mall/brand/index', 'fas fa-glass-martini', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('258', '1', '25', '供应商', 'backend', '', '/mall/vendor/index', 'fas fa-user-cog', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('272', '1', '27', '优惠券类型', 'backend', '', '/mall/coupon-type/index', 'fas fa-gift', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('273', '1', '27', '优惠券', 'backend', '', '/mall/coupon/index', 'fas fa-ticket-alt', '', '3', '0', '1', '50', '1', '1599358315', '1603847833', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('2101', '1', '210', '查看', 'backend', '', '/mall/order/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2102', '1', '210', '编辑', 'backend', '', '/mall/order/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2103', '1', '210', '删除', 'backend', '', '/mall/order/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2104', '1', '210', '启禁', 'backend', '', '/mall/order/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2105', '1', '210', '导出', 'backend', '', '/mall/order/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2106', '1', '210', '导入', 'backend', '', '/mall/order/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2131', '1', '213', '查看', 'backend', '', '/mall/invoice/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2132', '1', '213', '编辑', 'backend', '', '/mall/invoice/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2133', '1', '213', '删除', 'backend', '', '/mall/invoice/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2134', '1', '213', '启禁', 'backend', '', '/mall/invoice/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2135', '1', '213', '导出', 'backend', '', '/mall/invoice/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2136', '1', '213', '导入', 'backend', '', '/mall/invoice/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2151', '1', '215', '查看', 'backend', '', '/mall/refund/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2152', '1', '215', '编辑', 'backend', '', '/mall/refund/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2153', '1', '215', '删除', 'backend', '', '/mall/refund/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2154', '1', '215', '启禁', 'backend', '', '/mall/refund/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2155', '1', '215', '导出', 'backend', '', '/mall/refund/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2156', '1', '215', '导入', 'backend', '', '/mall/refund/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2171', '1', '217', '查看', 'backend', '', '/mall/cart/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2172', '1', '217', '编辑', 'backend', '', '/mall/cart/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2173', '1', '217', '删除', 'backend', '', '/mall/cart/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2174', '1', '217', '启禁', 'backend', '', '/mall/cart/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2175', '1', '217', '导出', 'backend', '', '/mall/cart/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2176', '1', '217', '导入', 'backend', '', '/mall/cart/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('2241', '1', '224', '查看', 'backend', '', '/base/search-log/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2242', '1', '224', '编辑', 'backend', '', '/base/search-log/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2243', '1', '224', '删除', 'backend', '', '/base/search-log/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2244', '1', '224', '启禁', 'backend', '', '/base/search-log/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2245', '1', '224', '导出', 'backend', '', '/base/search-log/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2246', '1', '224', '导入', 'backend', '', '/base/search-log/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2261', '1', '226', '查看', 'backend', '', '/mall/address/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2262', '1', '226', '编辑', 'backend', '', '/mall/address/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2263', '1', '226', '删除', 'backend', '', '/mall/address/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2264', '1', '226', '启禁', 'backend', '', '/mall/address/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2265', '1', '226', '导出', 'backend', '', '/mall/address/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2266', '1', '226', '导入', 'backend', '', '/mall/address/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');

INSERT INTO `fb_base_permission` VALUES ('2401', '1', '240', '查看', 'backend', '', '/mall/product/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2402', '1', '240', '编辑', 'backend', '', '/mall/product/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2403', '1', '240', '删除', 'backend', '', '/mall/product/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2404', '1', '240', '启禁', 'backend', '', '/mall/product/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2405', '1', '240', '导出', 'backend', '', '/mall/product/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2406', '1', '240', '导入', 'backend', '', '/mall/product/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2431', '1', '243', '查看', 'backend', '', '/mall/review/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2432', '1', '243', '编辑', 'backend', '', '/mall/review/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2433', '1', '243', '删除', 'backend', '', '/mall/review/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2434', '1', '243', '启禁', 'backend', '', '/mall/review/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2435', '1', '243', '导出', 'backend', '', '/mall/review/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2436', '1', '243', '导入', 'backend', '', '/mall/review/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2441', '1', '244', '查看', 'backend', '', '/mall/consultation/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2442', '1', '244', '编辑', 'backend', '', '/mall/consultation/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2443', '1', '244', '删除', 'backend', '', '/mall/consultation/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2444', '1', '244', '启禁', 'backend', '', '/mall/consultation/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2445', '1', '244', '导出', 'backend', '', '/mall/consultation/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2446', '1', '244', '导入', 'backend', '', '/mall/consultation/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2451', '1', '245', '查看', 'backend', '', '/mall/favorite/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2452', '1', '245', '编辑', 'backend', '', '/mall/favorite/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2453', '1', '245', '删除', 'backend', '', '/mall/favorite/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2454', '1', '245', '启禁', 'backend', '', '/mall/favorite/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2455', '1', '245', '导出', 'backend', '', '/mall/favorite/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2456', '1', '245', '导入', 'backend', '', '/mall/favorite/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2481', '1', '248', '查看', 'backend', '', '/mall/category/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2482', '1', '248', '编辑', 'backend', '', '/mall/category/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2483', '1', '248', '删除', 'backend', '', '/mall/category/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2484', '1', '248', '启禁', 'backend', '', '/mall/category/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2485', '1', '248', '导出', 'backend', '', '/mall/category/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2486', '1', '248', '导入', 'backend', '', '/mall/category/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');


INSERT INTO `fb_base_permission` VALUES ('2511', '1', '251', '查看', 'backend', '', '/mall/attribute-set/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2512', '1', '251', '编辑', 'backend', '', '/mall/attribute-set/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2513', '1', '251', '删除', 'backend', '', '/mall/attribute-set/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2514', '1', '251', '启禁', 'backend', '', '/mall/attribute-set/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2515', '1', '251', '导出', 'backend', '', '/mall/attribute-set/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2516', '1', '251', '导入', 'backend', '', '/mall/attribute-set/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2521', '1', '252', '查看', 'backend', '', '/mall/attribute/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2522', '1', '252', '编辑', 'backend', '', '/mall/attribute/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2523', '1', '252', '删除', 'backend', '', '/mall/attribute/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2524', '1', '252', '启禁', 'backend', '', '/mall/attribute/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2525', '1', '252', '导出', 'backend', '', '/mall/attribute/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2526', '1', '252', '导入', 'backend', '', '/mall/attribute/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2531', '1', '253', '查看', 'backend', '', '/mall/attribute-item/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2532', '1', '253', '编辑', 'backend', '', '/mall/attribute-item/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2533', '1', '253', '删除', 'backend', '', '/mall/attribute-item/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2534', '1', '253', '启禁', 'backend', '', '/mall/attribute-item/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2535', '1', '253', '导出', 'backend', '', '/mall/attribute-item/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2536', '1', '253', '导入', 'backend', '', '/mall/attribute-item/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2551', '1', '255', '查看', 'backend', '', '/mall/param/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2552', '1', '255', '编辑', 'backend', '', '/mall/param/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2553', '1', '255', '删除', 'backend', '', '/mall/param/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2554', '1', '255', '启禁', 'backend', '', '/mall/param/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2555', '1', '255', '导出', 'backend', '', '/mall/param/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2556', '1', '255', '导入', 'backend', '', '/mall/param/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2561', '1', '256', '查看', 'backend', '', '/mall/tag/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2562', '1', '256', '编辑', 'backend', '', '/mall/tag/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2563', '1', '256', '删除', 'backend', '', '/mall/tag/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2564', '1', '256', '启禁', 'backend', '', '/mall/tag/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2565', '1', '256', '导出', 'backend', '', '/mall/tag/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2566', '1', '256', '导入', 'backend', '', '/mall/tag/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2571', '1', '257', '查看', 'backend', '', '/mall/brand/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2572', '1', '257', '编辑', 'backend', '', '/mall/brand/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2573', '1', '257', '删除', 'backend', '', '/mall/brand/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2574', '1', '257', '启禁', 'backend', '', '/mall/brand/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2575', '1', '257', '导出', 'backend', '', '/mall/brand/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2576', '1', '257', '导入', 'backend', '', '/mall/brand/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2581', '1', '258', '查看', 'backend', '', '/mall/vendor/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2582', '1', '258', '编辑', 'backend', '', '/mall/vendor/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2583', '1', '258', '删除', 'backend', '', '/mall/vendor/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2584', '1', '258', '启禁', 'backend', '', '/mall/vendor/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2585', '1', '258', '导出', 'backend', '', '/mall/vendor/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2586', '1', '258', '导入', 'backend', '', '/mall/vendor/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');


INSERT INTO `fb_base_permission` VALUES ('2721', '1', '272', '查看', 'backend', '', '/mall/coupon-type/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2722', '1', '272', '编辑', 'backend', '', '/mall/coupon-type/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2723', '1', '272', '删除', 'backend', '', '/mall/coupon-type/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2724', '1', '272', '启禁', 'backend', '', '/mall/coupon-type/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2725', '1', '272', '导出', 'backend', '', '/mall/coupon-type/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2726', '1', '272', '导入', 'backend', '', '/mall/coupon-type/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2731', '1', '273', '查看', 'backend', '', '/mall/coupon/view*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2732', '1', '273', '编辑', 'backend', '', '/mall/coupon/edit*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2733', '1', '273', '删除', 'backend', '', '/mall/coupon/delete*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2734', '1', '273', '启禁', 'backend', '', '/mall/coupon/status*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2735', '1', '273', '导出', 'backend', '', '/mall/coupon/export*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');
INSERT INTO `fb_base_permission` VALUES ('2736', '1', '273', '导入', 'backend', '', '/mall/coupon/import*', '', '', '4', '0', '1', '50', '1', '1', '1', '1', '1');


INSERT INTO `fb_base_setting_type` VALUES (21, 1, 0, 'backend', '商城基础', 'mall', '', 7, 1, 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (23, 1, 0, 'backend', '商城支付', 'mall_payment', '', 7, 1, 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);

INSERT INTO `fb_base_setting_type` VALUES (2150, 1, 21, 'backend', '默认货币', 'mall_currency_default', '默认货币', 7, 1, 'radioList', 'USD:USD,CNY:CNY,EUR:EUR,GBP:GBP', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (2151, 1, 21, 'backend', '货币', 'mall_currencies', '货币，商品价格乘以汇率为显示价格', 7, 1, 'multipleInputRow', 'code:货币代码,symbol:货币符号,rate:汇率', '[{\"code\":\"USD\",\"symbol\":\"$\",\"rate\":\"1\"},{\"code\":\"CNY\",\"symbol\":\"￥\",\"rate\":\"6.5\"},{\"code\":\"EUR\",\"symbol\":\"€\",\"rate\":\"0.93\"},{\"code\":\"GBP\",\"symbol\":\"£\",\"rate\":\"0.8\"}]', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (2321, 1, 23, 'backend', 'PayPal Client ID', 'mall_payment_paypal_client_id', '', 7, 1, 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);
INSERT INTO `fb_base_setting_type` VALUES (2322, 1, 23, 'backend', 'PayPal Secret', 'mall_payment_paypal_secret', '', 7, 1, 'text', '', '', 50, 1, 1600948360, 1600948360, 1, 1);

SET FOREIGN_KEY_CHECKS=1;
        ";

        //add user: admin  password: 123456
        $this->execute($sql);

    }

    public function down()
    {
        $sql = "
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `fb_mall_address`;
DROP TABLE IF EXISTS `fb_mall_brand`;
DROP TABLE IF EXISTS `fb_mall_vendor`;
DROP TABLE IF EXISTS `fb_mall_tag`;
DROP TABLE IF EXISTS `fb_mall_category`;
DROP TABLE IF EXISTS `fb_mall_attribute`;
DROP TABLE IF EXISTS `fb_mall_attribute_item`;
DROP TABLE IF EXISTS `fb_mall_attribute_set`;
DROP TABLE IF EXISTS `fb_mall_attribute_set_attribute`;
DROP TABLE IF EXISTS `fb_mall_product`;
DROP TABLE IF EXISTS `fb_mall_product_sku`;
DROP TABLE IF EXISTS `fb_mall_product_attribute_item_label`;
DROP TABLE IF EXISTS `fb_mall_product_tag`;
DROP TABLE IF EXISTS `fb_mall_cart`;
DROP TABLE IF EXISTS `fb_mall_review`;
DROP TABLE IF EXISTS `fb_mall_consultation`;
DROP TABLE IF EXISTS `fb_mall_favorite`;
DROP TABLE IF EXISTS `fb_mall_coupon_type`;
DROP TABLE IF EXISTS `fb_mall_coupon`;
DROP TABLE IF EXISTS `fb_mall_order`;
DROP TABLE IF EXISTS `fb_mall_order_product`;
DROP TABLE IF EXISTS `fb_mall_search_log`;
DROP TABLE IF EXISTS `fb_mall_param`;
DROP TABLE IF EXISTS `fb_mall_product_param`;
DROP TABLE IF EXISTS `fb_mall_refund`;
DROP TABLE IF EXISTS `fb_mall_invoice`;
DROP TABLE IF EXISTS `fb_mall_order_log`;
DROP TABLE IF EXISTS `fb_mall_point_log`;

SET FOREIGN_KEY_CHECKS=0;
        ";
        $this->execute($sql);
    }
}
