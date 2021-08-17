<?php

namespace common\models\oauth;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%oauth_access_token}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property string $client_id 客户ID
 * @property int $user_id 用户
 * @property string $access_token 访问Token
 * @property string|null $scope 范围
 * @property int $expired_at 过期时间
 * @property string $grant_type 授权类型
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class AccessToken extends AccessTokenBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%oauth_access_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'user_id', 'expired_at', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['client_id', 'access_token'], 'required'],
            [['scope'], 'safe'],
            [['name', 'client_id', 'access_token', 'grant_type'], 'string', 'max' => 255],
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
                'user_id' => '用户',
                'access_token' => '访问Token',
                'scope' => '范围',
                'expired_at' => '过期时间',
                'grant_type' => '授权类型',
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
                'user_id' => Yii::t('app', 'User ID'),
                'access_token' => Yii::t('app', 'Access Token'),
                'scope' => Yii::t('app', 'Scope'),
                'expired_at' => Yii::t('app', 'Expired At'),
                'grant_type' => Yii::t('app', 'Grant Type'),
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
