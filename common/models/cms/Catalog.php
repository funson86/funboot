<?php

namespace common\models\cms;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%cms_catalog}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $parent_id 父节点
 * @property string $name 标题
 * @property string $code 代码
 * @property int $is_nav 导航栏显示
 * @property string|null $banner 横幅图
 * @property string|null $banner_h5 手机横幅图
 * @property string $seo_title 搜索优化标题
 * @property string $seo_keywords 搜索优化关键词
 * @property string|null $seo_description 搜索优化描述
 * @property string|null $brief 简述
 * @property string|null $content 内容
 * @property string $redirect_url 跳转链接
 * @property int $page_size 分页数量
 * @property int $kind 种类
 * @property string $template 模板
 * @property string $template_page 详情页模板
 * @property string $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Catalog extends CatalogBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_catalog}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'parent_id', 'is_nav', 'page_size', 'kind', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['banner', 'banner_h5'], 'safe'],
            [['seo_description', 'brief', 'content'], 'string'],
            [['name', 'code', 'seo_title', 'seo_keywords', 'redirect_url', 'template', 'template_page', 'type'], 'string', 'max' => 255],
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
                'parent_id' => '父节点',
                'name' => '标题',
                'code' => '代码',
                'is_nav' => '导航栏显示',
                'banner' => '横幅图',
                'banner_h5' => '手机横幅图',
                'seo_title' => '搜索优化标题',
                'seo_keywords' => '搜索优化关键词',
                'seo_description' => '搜索优化描述',
                'brief' => '简述',
                'content' => '内容',
                'redirect_url' => '跳转链接',
                'page_size' => '分页数量',
                'kind' => '种类',
                'template' => '模板',
                'template_page' => '详情页模板',
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
                'parent_id' => Yii::t('app', 'Parent ID'),
                'name' => Yii::t('app', 'Name'),
                'code' => Yii::t('app', 'Code'),
                'is_nav' => Yii::t('app', 'Is Nav'),
                'banner' => Yii::t('app', 'Banner'),
                'banner_h5' => Yii::t('app', 'Banner H5'),
                'seo_title' => Yii::t('app', 'Seo Title'),
                'seo_keywords' => Yii::t('app', 'Seo Keywords'),
                'seo_description' => Yii::t('app', 'Seo Description'),
                'brief' => Yii::t('app', 'Brief'),
                'content' => Yii::t('app', 'Content'),
                'redirect_url' => Yii::t('app', 'Redirect Url'),
                'page_size' => Yii::t('app', 'Page Size'),
                'kind' => Yii::t('app', 'Kind'),
                'template' => Yii::t('app', 'Template'),
                'template_page' => Yii::t('app', 'Template Page'),
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
