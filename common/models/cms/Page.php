<?php

namespace common\models\cms;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%cms_page}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $catalog_id 栏目
 * @property string $name 标题
 * @property string|null $banner 封面图
 * @property string|null $banner_h5 手机封面图
 * @property string|null $thumb 缩略图
 * @property string|null $images 图片集
 * @property string $seo_title 搜索优化标题
 * @property string $seo_keywords 搜索关键词
 * @property string|null $seo_description 搜索描述
 * @property string|null $brief 简介
 * @property string|null $content 内容
 * @property float $price 价格
 * @property string $redirect_url 跳转链接
 * @property string $template 模板
 * @property int $click 浏览量
 * @property string $para1 页面参数1
 * @property string $para2 页面参数2
 * @property string $para3 页面参数3
 * @property string $para4 页面参数4
 * @property string $para5 页面参数5
 * @property string $para6 页面参数6
 * @property int $para7 页面参数7
 * @property int $para8 页面参数8
 * @property int $para9 页面参数9
 * @property float $para10 页面参数10
 * @property string $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Page extends PageBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'catalog_id', 'click', 'para7', 'para8', 'para9', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['banner', 'banner_h5', 'thumb', 'images'], 'safe'],
            [['seo_description', 'brief', 'content'], 'string'],
            [['price', 'para10'], 'number'],
            [['name', 'seo_title', 'seo_keywords', 'redirect_url', 'template', 'para1', 'para2', 'para3', 'para4', 'para5', 'para6', 'type'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        if (Yii::$app->language == Yii::$app->params['sqlCommentLanguage']) {
            return array_merge(parent::attributeLabels(), [
                'id' => Yii::t('app', 'ID'),
                'store_id' => '商家',
                'catalog_id' => '栏目',
                'name' => '标题',
                'banner' => '封面图',
                'banner_h5' => '手机封面图',
                'thumb' => '缩略图',
                'images' => '图片集',
                'seo_title' => '搜索优化标题',
                'seo_keywords' => '搜索关键词',
                'seo_description' => '搜索描述',
                'brief' => '简介',
                'content' => '内容',
                'price' => '价格',
                'redirect_url' => '跳转链接',
                'template' => '模板',
                'click' => '浏览量',
                'para1' => '页面参数1',
                'para2' => '页面参数2',
                'para3' => '页面参数3',
                'para4' => '页面参数4',
                'para5' => '页面参数5',
                'para6' => '页面参数6',
                'para7' => '页面参数7',
                'para8' => '页面参数8',
                'para9' => '页面参数9',
                'para10' => '页面参数10',
                'type' => '类型',
                'sort' => '排序',
                'status' => '状态',
                'created_at' => '创建时间',
                'updated_at' => '更新时间',
                'created_by' => '创建用户',
                'updated_by' => '更新用户',
            ]);
        } else {
            return array_merge(parent::attributeLabels(), [
                'id' => Yii::t('app', 'ID'),
                'store_id' => Yii::t('app', 'Store ID'),
                'catalog_id' => Yii::t('app', 'Catalog ID'),
                'name' => Yii::t('app', 'Name'),
                'banner' => Yii::t('app', 'Banner'),
                'banner_h5' => Yii::t('app', 'Banner H5'),
                'thumb' => Yii::t('app', 'Thumb'),
                'images' => Yii::t('app', 'Images'),
                'seo_title' => Yii::t('app', 'Seo Title'),
                'seo_keywords' => Yii::t('app', 'Seo Keywords'),
                'seo_description' => Yii::t('app', 'Seo Description'),
                'brief' => Yii::t('app', 'Brief'),
                'content' => Yii::t('app', 'Content'),
                'price' => Yii::t('app', 'Price'),
                'redirect_url' => Yii::t('app', 'Redirect Url'),
                'template' => Yii::t('app', 'Template'),
                'click' => Yii::t('app', 'Click'),
                'para1' => Yii::t('app', 'Para1'),
                'para2' => Yii::t('app', 'Para2'),
                'para3' => Yii::t('app', 'Para3'),
                'para4' => Yii::t('app', 'Para4'),
                'para5' => Yii::t('app', 'Para5'),
                'para6' => Yii::t('app', 'Para6'),
                'para7' => Yii::t('app', 'Para7'),
                'para8' => Yii::t('app', 'Para8'),
                'para9' => Yii::t('app', 'Para9'),
                'para10' => Yii::t('app', 'Para10'),
                'type' => Yii::t('app', 'Type'),
                'sort' => Yii::t('app', 'Sort'),
                'status' => Yii::t('app', 'Status'),
                'created_at' => Yii::t('app', 'Created At'),
                'updated_at' => Yii::t('app', 'Updated At'),
                'created_by' => Yii::t('app', 'Created By'),
                'updated_by' => Yii::t('app', 'Updated By'),
            ]);
        }
    }
}
