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
    const STATUS_MAINTENANCE = -5;

    const GRADE_NORMAL = 1;
    const GRADE_VIP_1 = 10;

    public $expiredTime;
    public $types;
    public $languages;
    public $langBackends;
    public $langFrontends;
    public $langApis;
    public $chains;

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

    public static function getStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = parent::getStatusLabels(null, true);
        $data += [
            self::STATUS_MAINTENANCE => Yii::t('cons', 'STATUS_MAINTENANCE'),
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
    public static function getGradeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::GRADE_NORMAL => Yii::t('cons', 'GRADE_NORMAL'),
            self::GRADE_VIP_1 => Yii::t('cons', 'GRADE_VIP_1'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getRouteLabels($id = null, $all = false, $flip = false)
    {
        $data = [];
        foreach (Yii::$app->params['routes'] as $k => $v) {
            $data[$k] = Yii::t('cons', $v);
        }

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
     * @param bool $isArray
     * @return array|mixed|null
     */
    public static function getLanguageCodeLabels($id = null, $all = false, $flip = false, $isArray = false)
    {
        return Lang::getLanguageCodeLabels($id, $all, $flip, $isArray);
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
            'expiredTime' => Yii::t('app', 'Expired At'),
            'remark' => Yii::t('app', 'Remark'),
            'language' => Yii::t('app', 'Language'),
            'languages' => Yii::t('app', 'Language'),
            'lang_source' => Yii::t('app', 'Lang Source'),
            'lang_frontend' => Yii::t('app', 'Lang Frontend'),
            'langFrontends' => Yii::t('app', 'Lang Frontends'),
            'lang_frontend_default' => Yii::t('app', 'Lang Frontend Default'),
            'lang_backend' => Yii::t('app', 'Lang Backend'),
            'langBackends' => Yii::t('app', 'Lang Backends'),
            'lang_backend_default' => Yii::t('app', 'Lang Backend Default'),
            'lang_api' => Yii::t('app', 'Lang Api'),
            'langApis' => Yii::t('app', 'Lang Apis'),
            'lang_api_default' => Yii::t('app', 'Lang Api Default'),
            'fund' => Yii::t('app', 'Fund'),
            'fund_amount' => Yii::t('app', 'Fund Amount'),
            'billable_fund' => Yii::t('app', 'Billable Fund'),
            'income' => Yii::t('app', 'Income'),
            'income_amount' => Yii::t('app', 'Income Amount'),
            'income_count' => Yii::t('app', 'Income Count'),
            'consume_count' => Yii::t('app', 'Consume Count'),
            'consume_amount' => Yii::t('app', 'Consume Amount'),
            'history_amount' => Yii::t('app', 'History Amount'),
            'param1' => Yii::t('app', 'Param1'),
            'param2' => Yii::t('app', 'Param2'),
            'param3' => Yii::t('app', 'Param3'),
            'param4' => Yii::t('app', 'Param4'),
            'param5' => Yii::t('app', 'Param5'),
            'param6' => Yii::t('app', 'Param6'),
            'grade' => Yii::t('app', 'Grade'),
            'type' => Yii::t('app', 'Type'),
            'types' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ]);
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
