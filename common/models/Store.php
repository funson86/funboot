<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "{{%store}}".
 *
 * @property int $id
 * @property int $parent_id 父节点
 * @property int $user_id 管理员
 * @property string $name 名称
 * @property string $brief 简介
 * @property string $host_name 域名
 * @property string $code 代码
 * @property string $qrcode 二维码
 * @property string $route 子系统
 * @property int $expired_at 到期时间
 * @property string|null $remark 备注
 * @property int $language 语言
 * @property string $lang_source 翻译源语言
 * @property int $lang_frontend 前端支持语言
 * @property string $lang_frontend_default 前端默认语言
 * @property int $lang_backend 后端支持语言
 * @property string $lang_backend_default 后端默认语言
 * @property int $lang_api API支持语言
 * @property string $lang_api_default API默认语言
 * @property int $consume_count 消费次数
 * @property float $consume_amount 消费金额
 * @property float $history_amount 历史金额
 * @property string $param1 参数1
 * @property string $param2 参数2
 * @property string $param3 参数3
 * @property int $param4 参数4
 * @property int $param5 参数5
 * @property float $param6 参数6
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Store extends StoreBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%store}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['parent_id', 'user_id', 'expired_at', 'language', 'lang_frontend', 'lang_backend', 'lang_api', 'consume_count', 'param4', 'param5', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['remark'], 'string'],
            [['consume_amount', 'history_amount', 'param6'], 'number'],
            [['name', 'brief', 'host_name', 'code', 'qrcode', 'route', 'lang_source', 'lang_frontend_default', 'lang_backend_default', 'lang_api_default', 'param1', 'param2', 'param3'], 'string', 'max' => 255],
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
                'parent_id' => '父节点',
                'user_id' => '管理员',
                'name' => '名称',
                'brief' => '简介',
                'host_name' => '域名',
                'code' => '代码',
                'qrcode' => '二维码',
                'route' => '子系统',
                'expired_at' => '到期时间',
                'remark' => '备注',
                'language' => '语言',
                'lang_source' => '翻译源语言',
                'lang_frontend' => '前端支持语言',
                'lang_frontend_default' => '前端默认语言',
                'lang_backend' => '后端支持语言',
                'lang_backend_default' => '后端默认语言',
                'lang_api' => 'API支持语言',
                'lang_api_default' => 'API默认语言',
                'consume_count' => '消费次数',
                'consume_amount' => '消费金额',
                'history_amount' => '历史金额',
                'param1' => '参数1',
                'param2' => '参数2',
                'param3' => '参数3',
                'param4' => '参数4',
                'param5' => '参数5',
                'param6' => '参数6',
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
                'parent_id' => Yii::t('app', 'Parent ID'),
                'user_id' => Yii::t('app', 'User ID'),
                'name' => Yii::t('app', 'Name'),
                'brief' => Yii::t('app', 'Brief'),
                'host_name' => Yii::t('app', 'Host Name'),
                'code' => Yii::t('app', 'Code'),
                'qrcode' => Yii::t('app', 'Qrcode'),
                'route' => Yii::t('app', 'Route'),
                'expired_at' => Yii::t('app', 'Expired At'),
                'remark' => Yii::t('app', 'Remark'),
                'language' => Yii::t('app', 'Language'),
                'lang_source' => Yii::t('app', 'Lang Source'),
                'lang_frontend' => Yii::t('app', 'Lang Frontend'),
                'lang_frontend_default' => Yii::t('app', 'Lang Frontend Default'),
                'lang_backend' => Yii::t('app', 'Lang Backend'),
                'lang_backend_default' => Yii::t('app', 'Lang Backend Default'),
                'lang_api' => Yii::t('app', 'Lang Api'),
                'lang_api_default' => Yii::t('app', 'Lang Api Default'),
                'consume_count' => Yii::t('app', 'Consume Count'),
                'consume_amount' => Yii::t('app', 'Consume Amount'),
                'history_amount' => Yii::t('app', 'History Amount'),
                'param1' => Yii::t('app', 'Param1'),
                'param2' => Yii::t('app', 'Param2'),
                'param3' => Yii::t('app', 'Param3'),
                'param4' => Yii::t('app', 'Param4'),
                'param5' => Yii::t('app', 'Param5'),
                'param6' => Yii::t('app', 'Param6'),
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
