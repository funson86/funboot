<?php

namespace common\models;

use Yii;
use common\models\Store;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property int $parent_id 父节点
 * @property string $username 帐号
 * @property string $auth_key 权限
 * @property string $token Token
 * @property string $access_token 访问Token
 * @property string $refresh_token 刷新Token
 * @property string $password_hash 密码
 * @property string $password_reset_token 重置密码
 * @property string $verification_token 校验Token
 * @property string $email 邮箱
 * @property string $mobile 手机
 * @property int $auth_role 用户类型
 * @property string $name 名称
 * @property string $avatar 头像
 * @property string $brief 简介
 * @property int $sex 性别
 * @property string $area 地区
 * @property int $province_id 省
 * @property int $city_id 市
 * @property int $district_id 区
 * @property string $address 地址
 * @property string|null $birthday 生日
 * @property int $point 积分
 * @property float $balance 余额
 * @property string $remark 备注
 * @property int $last_login_at 最近登录时间
 * @property string $last_login_ip 最近登录IP
 * @property int $last_paid_at 最近消费时间
 * @property string $last_paid_ip 最近消费IP
 * @property int $consume_count 消费次数
 * @property float $consume_amount 消费金额
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class User extends UserBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'parent_id', 'auth_role', 'sex', 'province_id', 'city_id', 'district_id', 'point', 'last_login_at', 'last_paid_at', 'consume_count', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['username'], 'required'],
            [['birthday'], 'safe'],
            [['balance', 'consume_amount'], 'number'],
            [['username'], 'string', 'max' => 190],
            [['auth_key'], 'string', 'max' => 32],
            [['token'], 'string', 'max' => 64],
            [['access_token', 'refresh_token', 'password_hash', 'password_reset_token', 'verification_token', 'email', 'mobile', 'name', 'brief', 'area', 'address', 'remark', 'last_login_ip', 'last_paid_ip'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 1022],
            [['username'], 'unique'],
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
                'username' => '帐号',
                'auth_key' => '权限',
                'token' => 'Token',
                'access_token' => '访问Token',
                'refresh_token' => '刷新Token',
                'password_hash' => '密码',
                'password_reset_token' => '重置密码',
                'verification_token' => '校验Token',
                'email' => '邮箱',
                'mobile' => '手机',
                'auth_role' => '用户类型',
                'name' => '名称',
                'avatar' => '头像',
                'brief' => '简介',
                'sex' => '性别',
                'area' => '地区',
                'province_id' => '省',
                'city_id' => '市',
                'district_id' => '区',
                'address' => '地址',
                'birthday' => '生日',
                'point' => '积分',
                'balance' => '余额',
                'remark' => '备注',
                'last_login_at' => '最近登录时间',
                'last_login_ip' => '最近登录IP',
                'last_paid_at' => '最近消费时间',
                'last_paid_ip' => '最近消费IP',
                'consume_count' => '消费次数',
                'consume_amount' => '消费金额',
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
                'username' => Yii::t('app', 'Username'),
                'auth_key' => Yii::t('app', 'Auth Key'),
                'token' => Yii::t('app', 'Token'),
                'access_token' => Yii::t('app', 'Access Token'),
                'refresh_token' => Yii::t('app', 'Refresh Token'),
                'password_hash' => Yii::t('app', 'Password Hash'),
                'password_reset_token' => Yii::t('app', 'Password Reset Token'),
                'verification_token' => Yii::t('app', 'Verification Token'),
                'email' => Yii::t('app', 'Email'),
                'mobile' => Yii::t('app', 'Mobile'),
                'auth_role' => Yii::t('app', 'Auth Role'),
                'name' => Yii::t('app', 'Name'),
                'avatar' => Yii::t('app', 'Avatar'),
                'brief' => Yii::t('app', 'Brief'),
                'sex' => Yii::t('app', 'Sex'),
                'area' => Yii::t('app', 'Area'),
                'province_id' => Yii::t('app', 'Province ID'),
                'city_id' => Yii::t('app', 'City ID'),
                'district_id' => Yii::t('app', 'District ID'),
                'address' => Yii::t('app', 'Address'),
                'birthday' => Yii::t('app', 'Birthday'),
                'point' => Yii::t('app', 'Point'),
                'balance' => Yii::t('app', 'Balance'),
                'remark' => Yii::t('app', 'Remark'),
                'last_login_at' => Yii::t('app', 'Last Login At'),
                'last_login_ip' => Yii::t('app', 'Last Login Ip'),
                'last_paid_at' => Yii::t('app', 'Last Paid At'),
                'last_paid_ip' => Yii::t('app', 'Last Paid Ip'),
                'consume_count' => Yii::t('app', 'Consume Count'),
                'consume_amount' => Yii::t('app', 'Consume Amount'),
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
