<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%base_profile}}" to add your code.
 *
 * @property Store $store
 */
class ProfileBase extends BaseModel
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
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'name' => Yii::t('app', 'Name'),
            'company' => Yii::t('app', 'Company'),
            'location' => Yii::t('app', 'Location'),
            'topic' => Yii::t('app', 'Topic'),
            'like' => Yii::t('app', 'Like'),
            'hate' => Yii::t('app', 'Hate'),
            'thanks' => Yii::t('app', 'Thanks'),
            'follow' => Yii::t('app', 'Follow'),
            'click' => Yii::t('app', 'Click'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @param $id
     * @param $field
     * @param $value
     * @return bool|Profile
     * @throws \yii\base\InvalidConfigException
     */
    public static function setFieldValue($id, $field, $value, $isCounter = false)
    {
        $model = Profile::findOne($id);
        if (!$model) {
            $model = new Profile();
            $model->id = $id;
        }

        if (isset($model->{$field})) {
            $isCounter ? $model->{$field} = intval($model->{$field}) + $value : $model->{$field} = $value;
        }

        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return false;
        }

        return $model;
    }
}
