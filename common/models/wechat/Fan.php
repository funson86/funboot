<?php

namespace common\models\wechat;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%wechat_fan}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property string $description 简介
 * @property string $unionid 唯一微信ID
 * @property string $openid Open Id
 * @property string $nickname 昵称
 * @property string $headimgurl 头像
 * @property int $sex 性别
 * @property int $groupid 组号
 * @property int $subscribe 关注
 * @property int $subscribe_time 关注时间
 * @property string $subscribe_scene 关注场景
 * @property string|null $tagid_list 标签ID
 * @property string $remark 备注
 * @property string $country 国家
 * @property string $province 省份
 * @property string $city 城市
 * @property string $language 语言
 * @property int $qr_scene 二维码场景
 * @property string $qr_scene_str 二维码场景描述
 * @property string $last_longitude 最后一次经度
 * @property string $last_latitude 最后一次纬度
 * @property string $last_address 最后一次地址
 * @property int $last_updated_at 最后一次时间
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Fan extends FanBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wechat_fan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'sex', 'groupid', 'subscribe', 'subscribe_time', 'qr_scene', 'last_updated_at', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['openid'], 'required'],
            [['tagid_list'], 'safe'],
            [['name', 'description', 'unionid', 'openid', 'nickname', 'headimgurl', 'subscribe_scene', 'remark', 'country', 'province', 'city', 'language', 'qr_scene_str', 'last_longitude', 'last_latitude', 'last_address'], 'string', 'max' => 255],
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
                'description' => '简介',
                'unionid' => '唯一微信ID',
                'openid' => 'Open Id',
                'nickname' => '昵称',
                'headimgurl' => '头像',
                'sex' => '性别',
                'groupid' => '组号',
                'subscribe' => '关注',
                'subscribe_time' => '关注时间',
                'subscribe_scene' => '关注场景',
                'tagid_list' => '标签ID',
                'remark' => '备注',
                'country' => '国家',
                'province' => '省份',
                'city' => '城市',
                'language' => '语言',
                'qr_scene' => '二维码场景',
                'qr_scene_str' => '二维码场景描述',
                'last_longitude' => '最后一次经度',
                'last_latitude' => '最后一次纬度',
                'last_address' => '最后一次地址',
                'last_updated_at' => '最后一次时间',
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
                'description' => Yii::t('app', 'Description'),
                'unionid' => Yii::t('app', 'Unionid'),
                'openid' => Yii::t('app', 'Openid'),
                'nickname' => Yii::t('app', 'Nickname'),
                'headimgurl' => Yii::t('app', 'Headimgurl'),
                'sex' => Yii::t('app', 'Sex'),
                'groupid' => Yii::t('app', 'Groupid'),
                'subscribe' => Yii::t('app', 'Subscribe'),
                'subscribe_time' => Yii::t('app', 'Subscribe Time'),
                'subscribe_scene' => Yii::t('app', 'Subscribe Scene'),
                'tagid_list' => Yii::t('app', 'Tagid List'),
                'remark' => Yii::t('app', 'Remark'),
                'country' => Yii::t('app', 'Country'),
                'province' => Yii::t('app', 'Province'),
                'city' => Yii::t('app', 'City'),
                'language' => Yii::t('app', 'Language'),
                'qr_scene' => Yii::t('app', 'Qr Scene'),
                'qr_scene_str' => Yii::t('app', 'Qr Scene Str'),
                'last_longitude' => Yii::t('app', 'Last Longitude'),
                'last_latitude' => Yii::t('app', 'Last Latitude'),
                'last_address' => Yii::t('app', 'Last Address'),
                'last_updated_at' => Yii::t('app', 'Last Updated At'),
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
