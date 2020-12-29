<?php

namespace common\models\mongodb;

use Yii;

/**
 * This is the model class for table "{{%base_log}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $user_id 用户
 * @property string $name 用户名
 * @property string $url Url
 * @property string $method 提交方式
 * @property string|null $params 请求数据
 * @property string $user_agent UA信息
 * @property int $agent_type 终端类型
 * @property string $ip IP地址
 * @property string $ip_info IP信息
 * @property int $code 返回码
 * @property string $msg 返回信息
 * @property string|null $data 数据
 * @property float $cost_time 耗时
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Log extends LogBase
{
    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'base_log';
    }

    /**
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return array_keys($this->attributeLabels());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'user_id', 'agent_type', 'code', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['params', 'data'], 'string'],
            [['cost_time'], 'number'],
            [['name', 'url', 'method', 'user_agent', 'ip_info', 'msg'], 'string', 'max' => 255],
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
                '_id' => Yii::t('app', 'ID'),
                'store_id' => '商家',
                'user_id' => '用户',
                'name' => '用户名',
                'url' => 'Url',
                'method' => '提交方式',
                'params' => '请求数据',
                'user_agent' => 'UA信息',
                'agent_type' => '终端类型',
                'ip' => 'IP地址',
                'ip_info' => 'IP信息',
                'code' => '返回码',
                'msg' => '返回信息',
                'data' => '数据',
                'cost_time' => '耗时',
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
                '_id' => Yii::t('app', 'ID'),
                'store_id' => Yii::t('app', 'Store ID'),
                'user_id' => Yii::t('app', 'User ID'),
                'name' => Yii::t('app', 'Name'),
                'url' => Yii::t('app', 'Url'),
                'method' => Yii::t('app', 'Method'),
                'params' => Yii::t('app', 'Params'),
                'user_agent' => Yii::t('app', 'User Agent'),
                'agent_type' => Yii::t('app', 'Agent Type'),
                'ip' => Yii::t('app', 'Ip'),
                'ip_info' => Yii::t('app', 'Ip Info'),
                'code' => Yii::t('app', 'Code'),
                'msg' => Yii::t('app', 'Msg'),
                'data' => Yii::t('app', 'Data'),
                'cost_time' => Yii::t('app', 'Cost Time'),
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
