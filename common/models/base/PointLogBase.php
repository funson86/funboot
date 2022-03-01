<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model base class for table "{{%base_point_log}}" to add your code.
 *
 * @property Store $store
 */
class PointLogBase extends BaseModel
{
    const TYPE_BOUGHT = 1;
    const TYPE_COMMENT = 2;
    const TYPE_BUYING = 11;
    const TYPE_REGISTER = 21;
    const TYPE_RECOMMEND = 22;

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
     * @param null $id
     * @param bool $flip
     * @param bool $all
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_BOUGHT => Yii::t('cons', 'TYPE_BOUGHT'),
            self::TYPE_COMMENT => Yii::t('cons', 'TYPE_COMMENT'),
            self::TYPE_BUYING => Yii::t('cons', 'TYPE_BUYING'),
            self::TYPE_REGISTER => Yii::t('cons', 'TYPE_REGISTER'),
            self::TYPE_RECOMMEND => Yii::t('cons', 'TYPE_RECOMMEND'),
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
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'change' => Yii::t('app', 'Change'),
            'original' => Yii::t('app', 'Original'),
            'balance' => Yii::t('app', 'Balance'),
            'remark' => Yii::t('app', 'Remark'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ]);
    }

    public static function create($change, $original, $balance, $name = '', $type = self::TYPE_BOUGHT, $ip = null, $userId = null, $sessionId = null)
    {
        $model = new PointLog();
        $model->name = $name;
        $model->user_id = Yii::$app->user->id;
        $model->change = $change;
        $model->original = $original;
        $model->balance = $balance;
        $model->type = PointLog::TYPE_BOUGHT;
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            throw new NotFoundHttpException('PointLog Error');
        }

        return true;
    }
}
