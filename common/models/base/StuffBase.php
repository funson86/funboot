<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;
use yii\helpers\Html;

/**
 * This is the model base class for table "{{%base_stuff}}" to add your code.
 *
 * @property Store $store
 */
class StuffBase extends BaseModel
{
    public $codes = [];
    public $mapCode = [];

    const TYPE_TEXT = 1;
    const TYPE_IMAGE = 2;

    const POSITION_ALL = 0;
    const POSITION_DEFAULT = 1;
    const POSITION_TOP = 10;
    const POSITION_LEFT = 20;
    const POSITION_RIGHT = 30;
    const POSITION_CENTER = 40;
    const POSITION_BOTTOM = 50;

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
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_TEXT => Yii::t('cons', 'TYPE_TEXT'),
            self::TYPE_IMAGE => Yii::t('cons', 'TYPE_IMAGE'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    public static function getPositionLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::POSITION_DEFAULT => Yii::t('cons', 'POSITION_DEFAULT'),
            self::POSITION_TOP => Yii::t('cons', 'POSITION_TOP'),
            self::POSITION_LEFT => Yii::t('cons', 'POSITION_LEFT'),
            self::POSITION_RIGHT => Yii::t('cons', 'POSITION_RIGHT'),
            self::POSITION_CENTER => Yii::t('cons', 'POSITION_CENTER'),
            self::POSITION_BOTTOM => Yii::t('cons', 'POSITION_BOTTOM'),
        ];

        if (isset(Yii::$app->params['stuffPosition']) && is_array(Yii::$app->params['stuffPosition']) && count(Yii::$app->params['stuffPosition']) > 0) {
            foreach (Yii::$app->params['stuffPosition'] as $k => $v) {
                $data[$k] = Yii::t('app', $v);
            }
        }

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
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'codes' => Yii::t('app', 'Code'),
            'brief' => Yii::t('app', 'Brief'),
            'content' => Yii::t('app', 'Content'),
            'url' => Yii::t('app', 'Url'),
            'position' => Yii::t('app', 'Position'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ]);
    }

    public static function getById($id, $storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        return self::find()->where(['id' => $id, 'store_id' => $storeId])->one();
    }

    /**
     * @param $codeId
     * @param null $position
     * @param null $type
     * @param int $limit
     * @param null $storeId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getByCodeId($codeId = null, $position = null, $type = null, $limit = 0, $storeId = null)
    {
        !$storeId && $storeId = Yii::$app->storeSystem->getId();
        $query = static::find()->where(['store_id' => $storeId, 'status' => self::STATUS_ACTIVE]);

        $codeId && $query->andWhere('JSON_CONTAINS(`code`, \'"' . $codeId . '"\', \'$\')');
        $position && $query->andFilterWhere(['position' => $position]);
        $type && $query->andFilterWhere(['type' => $type]);
        $limit > 0 && $query->limit($limit);
        $query->orderBy(['position' => SORT_ASC, 'type' => SORT_ASC]);

        return $query->all();
    }

    public static function getHtmlByCodeId($codeId, $position = null, $type = null, $limit = 0, $storeId = null)
    {
        $models = static::getByCodeId($codeId, $position, $type, $limit, $storeId);

        $str = '';
        foreach ($models as $model) {
            $str .= Html::a($model->content, $model->url);
        }

        return $str;
    }
}
