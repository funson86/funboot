<?php

namespace common\models;

use common\helpers\Html;
use common\models\base\Attachment;
use common\models\base\Department;
use common\models\base\DictData;
use common\models\base\Log;
use common\models\base\Message;
use common\models\base\MessageSend;
use common\models\base\Permission;
use common\models\base\Role;
use common\models\base\RolePermission;
use common\models\base\Schedule;
use common\models\base\Setting;
use common\models\base\SettingType;
use common\models\base\UserRole;
use common\models\BaseModel;
use Yii;

/**
 * This is the model base class for table "{{%store}}" to add your code.
 *
 * @property Attachment[] $attachments
 * @property Department[] $departments
 * @property DictData[] $dictDatas
 * @property Log[] $logs
 * @property Message[] $messages
 * @property MessageSend[] $messageSends
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

    const PRINTER_TYPE_JIABO = 'Jiabo58';
    const PRINTER_TYPE_FEIE = 'Feie58';

    const ROUTE_SITE = 'site';
    const ROUTE_MALL = 'mall';
    const ROUTE_CMS = 'cms';
    const ROUTE_PAY = 'pay';

    const TYPE_TABLE_ORDER = 1;
    const TYPE_GIFT_VOUCHER = 2;
    const TYPE_TABLE_QRCODE = 4;

    const LANGUAGE_EN = 1;
    const LANGUAGE_ZH_CN = 2;

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
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_TABLE_ORDER => Yii::t('cons', 'TYPE_TABLE_ORDER'),
            self::TYPE_GIFT_VOUCHER => Yii::t('cons', 'TYPE_GIFT_VOUCHER'),
            self::TYPE_TABLE_QRCODE => Yii::t('cons', 'TYPE_TABLE_QRCODE'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            $str = '';
            foreach ($data as $k => $v) {
                if (($id & $k) == $k) {
                    $str .= $data[$k] . ' ';
                }
            }
            return $str;
        }
        return $data;
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getLanguageLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::LANGUAGE_EN => Yii::t('cons', 'LANGUAGE_EN'),
            self::LANGUAGE_ZH_CN => Yii::t('cons', 'LANGUAGE_ZH_CN'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            $str = '';
            foreach ($data as $k => $v) {
                if (($id & $k) == $k) {
                    $str .= $data[$k] . ' ';
                }
            }
            return $str;
        }
        return $data;
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getLanguageCode($id = null, $all = false, $flip = false)
    {
        $data = [
            self::LANGUAGE_EN => 'en',
            self::LANGUAGE_ZH_CN => 'zh-CN',
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'host_name' => Yii::t('app', 'Host Name'),
            'router' => Yii::t('app', 'Router'),
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
    public function getMessageSends()
    {
        return $this->hasMany(MessageSend::className(), ['store_id' => 'id']);
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

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
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

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
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

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
    }

}
