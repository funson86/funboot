<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model base class for table "{{%base_balance_log}}" to add your code.
 *
 * @property Store $store
 * @property User $user
 */
class BalanceLogBase extends BaseModel
{
    const TYPE_CONSUME = 1;
    const TYPE_RECHARGE = 2;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            self::TYPE_CONSUME => Yii::t('cons', 'TYPE_CONSUME'),
            self::TYPE_RECHARGE => Yii::t('cons', 'TYPE_RECHARGE'),
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

    public static function create($change, $original, $balance, $name = '', $type = self::TYPE_CONSUME, $userId = null, $storeId = null)
    {
        $model = new BalanceLog();
        $storeId && $model->store_id = $storeId;
        $model->name = $name;
        $model->user_id = $userId ?? Yii::$app->user->id;
        $model->change = $change;
        $model->original = $original;
        $model->balance = $balance;
        $model->type = $type;
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            throw new NotFoundHttpException('BalanceLog Error');
        }

        return true;
    }
}
