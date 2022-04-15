<?php

namespace common\models;

use common\helpers\ArrayHelper;
use common\helpers\IdHelper;
use common\models\base\Log;
use Yii;
use yii\base\ModelEvent;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\log\Logger;

/**
 * Class BaseModel
 * @package common\models
 * @author funson86 <funson86@gmail.com>
 *
 * @property User $user
 * @property User $createdBy
 * @property User $updatedBy
 * @property Store $store
 */
class BaseModel extends ActiveRecord
{
    static $tableCode = 0;
    static $mapLangFieldType = [
        'name' => 'text',
    ];
    public $translating = 0;

    /** @var array multiple type */
    public $types;

    /**
     * 是否启用高并发，需要启用的在XxxBase中设置
     * @var bool
     */
    protected $highConcurrency = false;

    const SORT_DEFAULT = 50;
    const SORT_TOP = 10;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_EXPIRED = -1;
    const STATUS_DELETED = -10;

    const TYPE_DEFAULT = 1;
    const TYPE_B = 2;

    public function __construct($config = [])
    {
        parent::__construct($config);

        // 高性能
        $this->highConcurrency && $this->id = IdHelper::snowFlakeId();

        // 设置store_id，store表没有该字段
        if (!$this instanceof Store) {
            $this->store_id = Yii::$app->storeSystem->getId();
        }

        $this->on(self::EVENT_AFTER_INSERT, [get_class($this), 'afterInsert']);
        $this->on(self::EVENT_AFTER_UPDATE, [get_class($this), 'afterUpdate']);
        $this->on(self::EVENT_BEFORE_DELETE, [get_class($this), 'beforeDeleteBase']);
    }

    /**
     * created_at, updated_at to now()
     *
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'defaultValue' => Yii::$app->storeSystem->getUserId(),
            ],
        ]);
    }

    public function attributeLabels()
    {
        return [
            'translating' => Yii::t('app', 'Translating'),
        ];
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @param bool $all
     * @return array|mixed
     */
    public static function getStatusLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::STATUS_ACTIVE => Yii::t('cons', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('cons', 'STATUS_INACTIVE'),
        ];

        $all && $data += [
            self::STATUS_EXPIRED => Yii::t('cons', 'STATUS_EXPIRED'),
            self::STATUS_DELETED => Yii::t('cons', 'STATUS_DELETED'),
        ];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_DEFAULT => Yii::t('cons', 'TYPE_DEFAULT'),
            self::TYPE_B => Yii::t('cons', 'TYPE_B'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @param string $glue
     * @return array|mixed
     */
    public static function getTypesLabel($id = null, $all = false, $flip = false, $glue = ' ')
    {
        if (is_null($id)) {
            return static::getTypeLabels($id, $all, $flip);
        }

        $data = static::getTypeLabels(null, true);
        $keys = array_keys($data);
        $list = [];
        foreach ($keys as $key) {
            if (($id & $key) === $key) {
                array_push($list, $data[$key]);
            }
        }

        return implode($glue, $list);
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @param string $glue
     * @return array|mixed
     */
    public static function getTypesLabels($id = null, $all = false, $flip = false, $glue = ' ')
    {
        if (!is_null($id)) {
            return static::getTypesLabel($id, $all, $flip);
        }

        $data = static::getTypeLabels(null, true);
        $count = count($data);
        $max = 1 << ($count - 1);
        $list = [];
        for ($i = 1; $i <= $count; $i++) {
            $list[$i] = static::getTypesLabel($i, true, false, $glue);
        }

        return $list;
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed
     */
    public static function getLangFieldType($id = null, $all = false, $flip = false)
    {
        $data = static::$mapLangFieldType;

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * 如果整型或者浮点型，输入为空强制转成0
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_array($this->rules())) {
                foreach ($this->rules() as $rule) {
                    if (isset($rule[1]) && (in_array($rule[1], ['integer', 'number'])) && is_array($rule[0])) {
                        foreach ($rule[0] as $attribute) {
                            $this->{$attribute} === '' && $this->{$attribute} = 0;
                        }
                    }
                }
            }

            // 如果是默认的store id，弄成当前ID
            if (!($this instanceof Store) && (!$this->store_id || $this->store_id <= 0/* || $this->store_id == Yii::$app->params['defaultStoreId']*/)) {
                $this->store_id = Yii::$app->storeSystem->getId();
            }

            return true;
        }
        return false;
    }

    public static function afterInsert(AfterSaveEvent $event)
    {
        Yii::$app->logSystem->operation(Log::CODE_INSERT, $event->sender->getAttributes());
    }

    public static function afterUpdate(AfterSaveEvent $event)
    {
        $old = $event->changedAttributes;
        $new = ArrayHelper::filter($event->sender->getAttributes(), array_keys($event->changedAttributes));
        Yii::$app->logSystem->operation(Log::CODE_UPDATE, ['old' =>$old, 'new' => $new], null);
    }

    public static function beforeDeleteBase($event)
    {
        Yii::$app->logSystem->operation(Log::CODE_DELETE, $event->sender->getOldAttributes());
    }

    public static function getTableCode()
    {
        return static::$tableCode;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return isset($this->attributes['user_id']) ? $this->hasOne(User::className(), ['id' => 'user_id']) : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return isset($this->attributes['store_id']) ? $this->hasOne(Store::className(), ['id' => 'store_id']) : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * 判断是否为所属
     * @return bool
     */
    public function isOwner()
    {
        if (!isset($this->user_id) || is_null(Yii::$app->user->id)) {
            return false;
        }
        return $this->user_id == Yii::$app->user->id;
    }

    /**
     *
     * @param $status
     * @return bool
     */
    public static function isStatusActiveInactive($status)
    {
        return in_array($status, [self::STATUS_INACTIVE, self::STATUS_ACTIVE]);
    }

    /**
     * @param bool $pleaseFilter
     * @param string $label
     * @param string $id
     * @param int $storeId
     * @param null $parentId
     * @return array|string[]
     */
    public static function getIdLabel($pleaseFilter = false, $label = 'name', $id = 'id', $storeId = null, $parentId = null)
    {
        if (!$storeId && !Yii::$app->authSystem->isAdmin()) {
            $storeId = Yii::$app->storeSystem->getId();
        }

        $models = self::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->andFilterWhere(['store_id' => $storeId])
            ->andFilterWhere(['parent_id' => $parentId])
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
            ->asArray()->all();

        return $pleaseFilter
            ? ArrayHelper::merge([0 => Yii::t('app', 'Please Filter')], ArrayHelper::map($models, $id, $label))
            : ArrayHelper::map($models, $id, $label);
    }

    /**
     * 显示树状
     * @param int $parentId
     * @param bool $root
     * @param string $rootLabel
     * @param int $storeId
     * @return array|string[]
     */
    public static function getTreeIdLabel($parentId = 0, $root = true, $rootLabel = null, $storeId = null)
    {
        if (!$storeId && !Yii::$app->authSystem->isAdmin()) {
            $storeId = Yii::$app->storeSystem->getId();
        }
        $models = self::find()->where(['status' => self::STATUS_ACTIVE])->andFilterWhere(['store_id' => $storeId])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->asArray()->all();
        $mapIdLabel = ArrayHelper::map(ArrayHelper::getTreeIdLabel(0, $models,  '└─'), 'id', 'label');

        if ($parentId == 0 && $root) {
            !$rootLabel && $rootLabel = Yii::t('app', 'Root Node');
            return [0 => $rootLabel] + $mapIdLabel;
        }
        return $mapIdLabel;
    }

}