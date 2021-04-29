<?php

namespace common\models\bbs;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "fb_bbs_raw".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $node_id 节点
 * @property string|null $node_ids 额外节点
 * @property string $name 名称
 * @property string|null $brief 简介
 * @property string|null $content 内容
 * @property string $url 网址
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 *
 * @property Store $store
 */
class Raw extends RawBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fb_bbs_raw';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'node_id', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['node_ids'], 'safe'],
            [['name'], 'required'],
            [['brief', 'content'], 'string'],
            [['name', 'url'], 'string', 'max' => 255],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        if (Yii::$app->language == Yii::$app->params['sqlCommentLanguage']) {
            return array_merge(parent::attributeLabels(), [
                'id' => 'ID',
                'store_id' => '商家',
                'node_id' => '节点',
                'node_ids' => '额外节点',
                'name' => '名称',
                'brief' => '简介',
                'content' => '内容',
                'url' => '网址',
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
                'id' => 'ID',
                'store_id' => 'Store ID',
                'node_id' => 'Node ID',
                'node_ids' => 'Node Ids',
                'name' => 'Name',
                'brief' => 'Brief',
                'content' => 'Content',
                'url' => 'Url',
                'type' => 'Type',
                'sort' => 'Sort',
                'status' => 'Status',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'created_by' => 'Created By',
                'updated_by' => 'Updated By',
            ]);
        }
    }


}
