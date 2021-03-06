<?php

namespace common\models;

use common\helpers\ArrayHelper;
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
 */
class BaseModel extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_EXPIRED = -1;
    const STATUS_DELETED = -10;

    const TYPE_A = 1;
    const TYPE_B = 2;

    public function __construct($config = [])
    {
        parent::__construct($config);

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
        // 未登录认为是store管理员登录, console下不一定有Yii::$app->user
        $userId = isset(Yii::$app->user) && !Yii::$app->user->getIsGuest() ? Yii::$app->user->id : Yii::$app->storeSystem->getUserId();
        return array_merge(parent::behaviors(), [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
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
        ]);
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

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
    }

    /**
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_A => Yii::t('cons', 'TYPE_A'),
            self::TYPE_B => Yii::t('cons', 'TYPE_B'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
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

    /**
     * @param int $parentId
     * @param int $storeId
     * @param string $rootLabel
     * @return array|string[]
     */
    public static function getIdLabel($storeId = null)
    {
        if (!$storeId && !Yii::$app->authSystem->isAdmin()) {
            $storeId = Yii::$app->storeSystem->getId();
        }
        $models = self::find()->where(['status' => self::STATUS_ACTIVE])->andFilterWhere(['store_id' => $storeId])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

    /**
     * @param int $parentId
     * @param int $storeId
     * @param string $rootLabel
     * @return array|string[]
     */
    public static function getTreeIdLabel($storeId = null, $parentId = 0, $rootLabel = 'Root Node')
    {
        if (!$storeId && !Yii::$app->authSystem->isAdmin()) {
            $storeId = Yii::$app->storeSystem->getId();
        }
        $models = self::find()->where(['status' => self::STATUS_ACTIVE])->andFilterWhere(['store_id' => $storeId])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->asArray()->all();
        $mapIdLabel = ArrayHelper::map(ArrayHelper::getTreeIdLabel(0, $models), 'id', 'label');

        if ($parentId == 0) {
            return [0 => Yii::t('app', $rootLabel)] + $mapIdLabel;
        }
        return $mapIdLabel;
    }

}