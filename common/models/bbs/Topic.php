<?php

namespace common\models\bbs;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%bbs_topic}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $node_id 栏目
 * @property int $tag_id 标签
 * @property string $name 标题
 * @property string|null $thumb 缩略图
 * @property string|null $images 图片集
 * @property string $seo_title 搜索优化标题
 * @property string $seo_keywords 搜索关键词
 * @property string|null $seo_description 搜索描述
 * @property string|null $meta 参数
 * @property string|null $brief 简介
 * @property string|null $content 内容
 * @property float $price 价格
 * @property string $redirect_url 跳转链接
 * @property string $template 模板
 * @property int $click 浏览量
 * @property int $like 点赞
 * @property int $comment 评论
 * @property int $is_comment 允许评论
 * @property int $category 种类
 * @property int $kind 特征
 * @property int $grade 等级
 * @property int $format 格式
 * @property int $user_id 作者
 * @property string $username 作者
 * @property string $user_avatar 作者头像
 * @property string $last_comment_username 最后回复用户名称
 * @property int $last_comment_user_id 最后回复用户
 * @property int $last_comment_updated_at 最后回复时间
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Topic extends TopicBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bbs_topic}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'node_id', 'tag_id', 'click', 'like', 'comment', 'is_comment', 'category', 'kind', 'grade', 'format', 'user_id', 'last_comment_user_id', 'last_comment_updated_at', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['thumb', 'images', 'meta'], 'safe'],
            [['seo_description', 'brief', 'content'], 'string'],
            [['price'], 'number'],
            [['name', 'seo_title', 'seo_keywords', 'redirect_url', 'template', 'username', 'user_avatar', 'last_comment_username'], 'string', 'max' => 255],
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
                'node_id' => '栏目',
                'tag_id' => '标签',
                'name' => '标题',
                'thumb' => '缩略图',
                'images' => '图片集',
                'seo_title' => '搜索优化标题',
                'seo_keywords' => '搜索关键词',
                'seo_description' => '搜索描述',
                'meta' => '参数',
                'brief' => '简介',
                'content' => '内容',
                'price' => '价格',
                'redirect_url' => '跳转链接',
                'template' => '模板',
                'click' => '浏览量',
                'like' => '点赞',
                'comment' => '评论',
                'is_comment' => '允许评论',
                'category' => '种类',
                'kind' => '特征',
                'grade' => '等级',
                'format' => '格式',
                'user_id' => '作者',
                'username' => '作者',
                'user_avatar' => '作者头像',
                'last_comment_username' => '最后回复用户名称',
                'last_comment_user_id' => '最后回复用户',
                'last_comment_updated_at' => '最后回复时间',
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
                'node_id' => Yii::t('app', 'Node ID'),
                'tag_id' => Yii::t('app', 'Tag ID'),
                'name' => Yii::t('app', 'Name'),
                'thumb' => Yii::t('app', 'Thumb'),
                'images' => Yii::t('app', 'Images'),
                'seo_title' => Yii::t('app', 'Seo Title'),
                'seo_keywords' => Yii::t('app', 'Seo Keywords'),
                'seo_description' => Yii::t('app', 'Seo Description'),
                'meta' => Yii::t('app', 'Meta'),
                'brief' => Yii::t('app', 'Brief'),
                'content' => Yii::t('app', 'Content'),
                'price' => Yii::t('app', 'Price'),
                'redirect_url' => Yii::t('app', 'Redirect Url'),
                'template' => Yii::t('app', 'Template'),
                'click' => Yii::t('app', 'Click'),
                'like' => Yii::t('app', 'Like'),
                'comment' => Yii::t('app', 'Comment'),
                'is_comment' => Yii::t('app', 'Is Comment'),
                'category' => Yii::t('app', 'Category'),
                'kind' => Yii::t('app', 'Kind'),
                'grade' => Yii::t('app', 'Grade'),
                'format' => Yii::t('app', 'Format'),
                'user_id' => Yii::t('app', 'User ID'),
                'username' => Yii::t('app', 'Username'),
                'user_avatar' => Yii::t('app', 'User Avatar'),
                'last_comment_username' => Yii::t('app', 'Last Comment Username'),
                'last_comment_user_id' => Yii::t('app', 'Last Comment User ID'),
                'last_comment_updated_at' => Yii::t('app', 'Last Comment Updated At'),
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
