<?php

namespace common\models\mongodb;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use \yii\mongodb\ActiveRecord;
use Yii;

/**
 * Class LogBase
 * @package common\models\mongodb
 * @author funson86 <funson86@gmail.com>
 */
class LogBase extends ActiveRecord
{
    const TYPE_OPERATION = 1;
    const TYPE_ERROR = 2;
    const TYPE_LOGIN = 3;
    const TYPE_DB = 4;
    const TYPE_CONSOLE = 5;
    const TYPE_MAIL = 6;

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    const AGENT_TYPE_PC = 1;
    const AGENT_TYPE_MOBILE = 2;

    const CODE_INSERT = 221;
    const CODE_UPDATE = 222;
    const CODE_DELETE = 223;
    const CODE_SUCCESS = 200;
    const CODE_LOGIN_FAILED = 599;

    const LEVEL_ERROR = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_INFO = 4;
    const LEVEL_TRACE = 8;
    const LEVEL_PROFILE = 0x40;

    /**
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
                'value' => $userId,
            ],
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['store_id'],
                ],
                'value' => Yii::$app->storeSystem->getId(),
            ],
        ];
    }

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
        ];
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_OPERATION => Yii::t('cons', 'TYPE_OPERATION'),
            self::TYPE_ERROR => Yii::t('cons', 'TYPE_ERROR'),
            self::TYPE_LOGIN => Yii::t('cons', 'TYPE_LOGIN'),
            self::TYPE_DB => Yii::t('cons', 'TYPE_DB'),
            self::TYPE_CONSOLE => Yii::t('cons', 'TYPE_CONSOLE'),
            self::TYPE_MAIL => Yii::t('cons', 'TYPE_MAIL'),
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
    public static function getMethodLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::METHOD_GET => Yii::t('cons', 'METHOD_GET'),
            self::METHOD_POST => Yii::t('cons', 'METHOD_POST'),
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
    public static function getAgentTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::AGENT_TYPE_PC => Yii::t('cons', 'AGENT_TYPE_PC'),
            self::AGENT_TYPE_MOBILE => Yii::t('cons', 'AGENT_TYPE_MOBILE'),
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
    public static function getCodeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::CODE_INSERT => Yii::t('cons', 'CODE_INSERT'),
            self::CODE_UPDATE => Yii::t('cons', 'CODE_UPDATE'),
            self::CODE_DELETE => Yii::t('cons', 'CODE_DELETE'),
            self::CODE_SUCCESS => Yii::t('cons', 'CODE_SUCCESS'),
            self::CODE_LOGIN_FAILED => Yii::t('cons', 'CODE_LOGIN_FAILED'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
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

    public static function getCodeLevel($code)
    {
        static $levelMap = [
            'error' => self::LEVEL_ERROR,
            'warning' => self::LEVEL_WARNING,
            'info' => self::LEVEL_INFO,
            'trace' => self::LEVEL_TRACE,
            'profile' => self::LEVEL_PROFILE,
        ];

        $levelMapRev = array_flip($levelMap);
        if ($code < 300) {
            return $levelMapRev[self::LEVEL_ERROR];
        } elseif (300 <= $code && $code < 400) {
            return $levelMapRev[self::LEVEL_INFO];
        } elseif (400 <= $code && $code < 500) {
            return $levelMapRev[self::LEVEL_WARNING];
        }

        return $levelMapRev[self::LEVEL_ERROR];
    }
}