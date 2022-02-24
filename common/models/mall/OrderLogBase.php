<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model base class for table "{{%mall_order_log}}" to add your code.
 *
 * @property Store $store
 * @property Order $order
 */
class OrderLogBase extends BaseModel
{
    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /** add function getXxxLabels here, detail in BaseModel **/

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public static function create($orderId, $status, $name = '', $ip = null, $userId = null, $sessionId = null)
    {
        $orderLog = new OrderLog();
        $orderLog->order_id = $orderId;
        $orderLog->user_id = $userId ?? (Yii::$app->user->isGuest ? 0 : Yii::$app->user->id);
        $orderLog->status = $status;
        if (!$orderLog->save()) {
            Yii::$app->logSystem->db($orderLog->errors);
            throw new NotFoundHttpException('OrderLog Error');
        }
        return true;
    }

}
