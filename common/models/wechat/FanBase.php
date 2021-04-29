<?php

namespace common\models\wechat;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%wechat_fan}}" to add your code.
 *
 * @property Store $store
 */
class FanBase extends BaseModel
{
    const SEX_UNKNOWN = 0;
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    const ADD_SCENE_SEARCH = 'ADD_SCENE_SEARCH';
    const ADD_SCENE_ACCOUNT_MIGRATION = 'ADD_SCENE_ACCOUNT_MIGRATION';
    const ADD_SCENE_PROFILE_CARD = 'ADD_SCENE_PROFILE_CARD';
    const ADD_SCENE_QR_CODE = 'ADD_SCENE_QR_CODE';
    const ADD_SCENE_PROFILE_LINK = 'ADD_SCENE_PROFILE_LINK';
    const ADD_SCENE_PROFILE_ITEM = 'ADD_SCENE_PROFILE_ITEM';
    const ADD_SCENE_PAID = 'ADD_SCENE_PAID';
    const ADD_SCENE_OTHERS = 'ADD_SCENE_OTHERS';

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /** add function getXxxLabels here, detail in BaseModel **/

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getSubscribeSceneLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::ADD_SCENE_SEARCH => Yii::t('cons', 'ADD_SCENE_SEARCH'),
            self::ADD_SCENE_ACCOUNT_MIGRATION => Yii::t('cons', 'ADD_SCENE_ACCOUNT_MIGRATION'),
            self::ADD_SCENE_PROFILE_CARD => Yii::t('cons', 'ADD_SCENE_PROFILE_CARD'),
            self::ADD_SCENE_QR_CODE => Yii::t('cons', 'ADD_SCENE_QR_CODE'),
            self::ADD_SCENE_PROFILE_LINK => Yii::t('cons', 'ADD_SCENE_PROFILE_LINK'),
            self::ADD_SCENE_PROFILE_ITEM => Yii::t('cons', 'ADD_SCENE_PROFILE_ITEM'),
            self::ADD_SCENE_PAID => Yii::t('cons', 'ADD_SCENE_PAID'),
            self::ADD_SCENE_OTHERS => Yii::t('cons', 'ADD_SCENE_OTHERS'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getSexLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::SEX_UNKNOWN => Yii::t('cons', 'SEX_UNKNOWN'),
            self::SEX_MALE => Yii::t('cons', 'SEX_MALE'),
            self::SEX_FEMALE => Yii::t('cons', 'SEX_FEMALE'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTagIdListLabels($ids = [], $data = [])
    {
        if (is_array($ids)) {
            $str = '';
            foreach ($ids as $id) {
                    $str .= isset($data[$id]) ? $data[$id] . ' ' : '';
            }
            return $str;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'name' => Yii::t('app', 'Name'),
            'brief' => Yii::t('app', 'Brief'),
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }
}
