<?php

namespace common\models;

use common\helpers\Html;
use common\models\base\Attachment;
use common\models\base\Department;
use common\models\base\DictData;
use common\models\base\Lang;
use common\models\base\Log;
use common\models\base\Message;
use common\models\base\MessageType;
use common\models\base\Permission;
use common\models\base\Role;
use common\models\base\RolePermission;
use common\models\base\Schedule;
use common\models\base\Setting;
use common\models\base\SettingType;
use common\models\base\UserRole;
use common\models\BaseModel;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model base class for table "{{%store}}" to add your code.
 *
 * @property Attachment[] $attachments
 * @property Department[] $departments
 * @property DictData[] $dictDatas
 * @property Log[] $logs
 * @property Message[] $messages
 * @property MessageType[] $messageTypes
 * @property Permission[] $permissions
 * @property Role[] $roles
 * @property RolePermission[] $rolePermissions
 * @property Schedule[] $schedules
 * @property Setting[] $settings
 * @property SettingType[] $settingTypes
 * @property UserRole[] $userRoles
 * @property User $user
 * @property User[] $users
 */
class StoreBase extends BaseModel
{
    const SUPPORT_SHIPMENT_DELIVERY = 1;
    const SUPPORT_SHIPMENT_COLLECTION = 2;
    const SUPPORT_SHIPMENT_BOTH = 3;

    const SUPPORT_PAYMENT_CARD = 1;
    const SUPPORT_PAYMENT_CASH = 2;
    const SUPPORT_PAYMENT_BOTH = 3;

    const ROUTE_SITE = 'site';
    const ROUTE_MALL = 'mall';
    const ROUTE_CMS = 'cms';
    const ROUTE_PAY = 'pay';
    const ROUTE_BBS = 'bbs';

    public $expiredTime;
    public $types;
    public $languages;

    /**
     * @var array 配置
     */
    public $settings = [];

    /**
     * @var array 通用数据，计算使用
     */
    public $commonData = [];

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * store里面没有store_id属性，需要删除
     * created_at, updated_at to now()
     *
     */
    public function behaviors()
    {
        // 未登录认为是store管理员登录, console下不一定有Yii::$app->user
        $userId = isset(Yii::$app->user) && !Yii::$app->user->getIsGuest() ? Yii::$app->user->id : Yii::$app->storeSystem->getUserId();
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
                'value' => $userId,
            ],
        ];
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getRouteLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::ROUTE_SITE => Yii::t('cons', 'ROUTE_SITE'),
            self::ROUTE_MALL => Yii::t('cons', 'ROUTE_MALL'),
            self::ROUTE_CMS => Yii::t('cons', 'ROUTE_CMS'),
            self::ROUTE_PAY => Yii::t('cons', 'ROUTE_PAY'),
            self::ROUTE_BBS => Yii::t('cons', 'ROUTE_BBS'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getLanguageLabels($id = null, $all = false, $flip = false)
    {
        return Lang::getLanguageLabels($id, $all, $flip);
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @param bool $isArray
     * @return array|mixed|null
     */
    public static function getLanguageCode($id = null, $all = false, $flip = false, $isArray = false)
    {
        return Lang::getLanguageCode($id, $all, $flip, $isArray);
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getLanguageBaiduCode($id = null, $all = false, $flip = false)
    {
        return Lang::getLanguageBaiduCode($id, $all, $flip);
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getLanguageFlag($id = null, $all = false, $flip = false)
    {
        return Lang::getLanguageFlag($id, $all, $flip);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'host_name' => Yii::t('app', 'Host Name'),
            'router' => Yii::t('app', 'Router'),
            'qrcode' => Yii::t('app', 'Qrcode'),
            'expired_at' => Yii::t('app', 'Expired At'),
            'expiredTime' => Yii::t('app', 'Expired At'),
            'remark' => Yii::t('app', 'Remark'),
            'language' => Yii::t('app', 'Language'),
            'languages' => Yii::t('app', 'Language'),
            'type' => Yii::t('app', 'Type'),
            'types' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictDatas()
    {
        return $this->hasMany(DictData::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageTypes()
    {
        return $this->hasMany(MessageType::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasMany(Permission::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePermissions()
    {
        return $this->hasMany(RolePermission::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingTypes()
    {
        return $this->hasMany(SettingType::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['store_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['store_id' => 'id']);
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getCurrencyLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            '£' => Yii::t('app', 'Pound Sterling'),
            '$' => Yii::t('app', 'US Dollar'),
            '€' => Yii::t('app', 'Euro'),
            '¥' => Yii::t('app', 'Yuan Renminbi'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * @param null $id
     * @param bool $flip
     * @return array|mixed|string|string[]|null
     */
    public static function getCurrencyPrinterLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            '£' => '￡',
            '$' => '$',
            '€' => '€',
            '¥' => '￥',
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * @param null $id
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getCurrencyShortName($id = null, $all = false, $flip = false)
    {
        $data = [
            '£' => Yii::t('app', 'GBP'),
            '$' => Yii::t('app', 'USD'),
            '€' => Yii::t('app', 'EUR'),
            '¥' => Yii::t('app', 'CNY'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

}
