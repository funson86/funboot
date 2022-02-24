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
 * @property string $code 代码
 * @property string|null $banner 封面图
 * @property string|null $banner_h5 手机封面图
 * @property string $thumb 缩略图
 * @property string|null $images 图片集
 * @property string $seo_title 搜索优化标题
 * @property string $seo_keywords 关键词
 * @property string|null $seo_description 描述
 * @property string|null $brief 简介
 * @property string|null $content 内容
 * @property float $price 价格
 * @property string $redirect_url 跳转链接
 * @property int $kind 种类
 * @property int $format 格式
 * @property string $template 模板
 * @property int $click 浏览量
 * @property string $param1 页面参数1
 * @property string $param2 页面参数2
 * @property string $param3 页面参数3
 * @property string $param4 页面参数4
 * @property string $param5 页面参数5
 * @property string $param6 页面参数6
 * @property int $param7 页面参数7
 * @property int $param8 页面参数8
 * @property int $param9 页面参数9
 * @property float $param10 页面参数10
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
            [['store_id', 'catalog_id', 'kind', 'format', 'click', 'param7', 'param8', 'param9', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['banner', 'banner_h5', 'images'], 'safe'],
            [['seo_description', 'brief', 'content'], 'string'],
            [['price', 'param10'], 'number'],
            [['name', 'code', 'thumb', 'seo_title', 'seo_keywords', 'redirect_url', 'template', 'param1', 'param2', 'param3', 'param4', 'param5', 'param6', 'type'], 'string', 'max' => 255],
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
                'code' => '代码',
                'banner' => '封面图',
                'banner_h5' => '手机封面图',
                'thumb' => '缩略图',
                'images' => '图片集',
                'seo_title' => '搜索优化标题',
                'seo_keywords' => '关键词',
                'seo_description' => '描述',
                'brief' => '简介',
                'content' => '内容',
                'price' => '价格',
                'redirect_url' => '跳转链接',
                'kind' => '种类',
                'format' => '格式',
                'template' => '模板',
                'click' => '浏览量',
                'param1' => '页面参数1',
                'param2' => '页面参数2',
                'param3' => '页面参数3',
                'param4' => '页面参数4',
                'param5' => '页面参数5',
                'param6' => '页面参数6',
                'param7' => '页面参数7',
                'param8' => '页面参数8',
                'param9' => '页面参数9',
                'param10' => '页面参数10',
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
                'code' => Yii::t('app', 'Code'),
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
                'kind' => Yii::t('app', 'Kind'),
                'format' => Yii::t('app', 'Format'),
                'template' => Yii::t('app', 'Template'),
                'click' => Yii::t('app', 'Click'),
                'param1' => Yii::t('app', 'Param1'),
                'param2' => Yii::t('app', 'Param2'),
                'param3' => Yii::t('app', 'Param3'),
                'param4' => Yii::t('app', 'Param4'),
                'param5' => Yii::t('app', 'Param5'),
                'param6' => Yii::t('app', 'Param6'),
                'param7' => Yii::t('app', 'Param7'),
                'param8' => Yii::t('app', 'Param8'),
                'param9' => Yii::t('app', 'Param9'),
                'param10' => Yii::t('app', 'Param10'),
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
