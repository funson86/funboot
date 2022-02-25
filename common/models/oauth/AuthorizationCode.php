<?php

namespace common\models\oauth;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%oauth_authorization_code}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property string $client_id 客户ID
 * @property string|null $scope 范围
 * @property int $expired_at 过期时间
 * @property string $redirect_uri 回调Uri
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class AuthorizationCode extends AuthorizationCodeBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%oauth_authorization_code}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'expired_at', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['client_id'], 'required'],
            [['scope'], 'safe'],
            [['name', 'client_id', 'redirect_uri'], 'string', 'max' => 255],
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
                'name' => '名称',
                'client_id' => '客户ID',
                'scope' => '范围',
                'expired_at' => '过期时间',
                'redirect_uri' => '回调Uri',
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
                'name' => Yii::t('app', 'Name'),
                'client_id' => Yii::t('app', 'Client ID'),
                'scope' => Yii::t('app', 'Scope'),
                'expired_at' => Yii::t('app', 'Expired At'),
                'redirect_uri' => Yii::t('app', 'Redirect Uri'),
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
