<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%base_search_log}}" to add your code.
 *
 * @property Store $store
 */
class SearchLogBase extends BaseModel
{
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'session_id' => Yii::t('app', 'Session ID'),
            'name' => Yii::t('app', 'Name'),
            'ip' => Yii::t('app', 'Ip'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ]);
    }

    public static function create($name, $ip = null, $userId = null, $sessionId = null)
    {
        $model = new SearchLog();
        $model->name = $name;
        $model->user_id = $userId ?? (Yii::$app->user->isGuest ? 0 : Yii::$app->user->id);
        $model->session_id = $sessionId ?? Yii::$app->session->id;
        $model->ip = $ip ?? (Yii::$app->request->getRemoteIP() ?? '');
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return false;
        }

        return true;
    }
}
