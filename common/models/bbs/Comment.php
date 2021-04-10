<?php

namespace common\models\bbs;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%bbs_comment}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $parent_id 父节点
 * @property int $topic_id 话题
 * @property int $user_id 用户
 * @property string $name 标题
 * @property string|null $content 内容
 * @property int $like 点赞
 * @property string $ip IP地址
 * @property string $ip_info IP信息
 * @property string $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Comment extends CommentBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bbs_comment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'parent_id', 'topic_id', 'user_id', 'like', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['content'], 'string'],
            [['name', 'ip_info', 'type'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 16],
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
                'topic_id' => '话题',
                'user_id' => '用户',
                'name' => '标题',
                'content' => '内容',
                'like' => '点赞',
                'ip' => 'IP地址',
                'ip_info' => 'IP信息',
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
                'topic_id' => Yii::t('app', 'Topic ID'),
                'user_id' => Yii::t('app', 'User ID'),
                'name' => Yii::t('app', 'Name'),
                'content' => Yii::t('app', 'Content'),
                'like' => Yii::t('app', 'Like'),
                'ip' => Yii::t('app', 'Ip'),
                'ip_info' => Yii::t('app', 'Ip Info'),
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
