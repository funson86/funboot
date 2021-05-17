<?php

namespace common\models\bbs;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%bbs_user_action}}" to add your code.
 *
 * @property User $user
 * @property Store $store
 */
class UserActionBase extends BaseModel
{
    const TYPE_TOPIC = 1;
    const TYPE_COMMENT = 2;

    const ACTION_LIKE = 1;
    const ACTION_HATE = 2;
    const ACTION_FOLLOW = 3;
    const ACTION_THANKS = 4;
    const ACTION_FAVORITE = 5;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /** add function getXxxLabels here, detail in BaseModel **/

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
            self::TYPE_TOPIC => Yii::t('cons', 'TYPE_TOPIC'),
            self::TYPE_COMMENT => Yii::t('cons', 'TYPE_COMMENT'),
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
     * @return array|mixed
     */
    public static function getActionLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::ACTION_LIKE => Yii::t('cons', 'ACTION_LIKE'),
            self::ACTION_HATE => Yii::t('cons', 'ACTION_HATE'),
            self::ACTION_FOLLOW => Yii::t('cons', 'ACTION_FOLLOW'),
            self::ACTION_THANKS => Yii::t('cons', 'ACTION_THANKS'),
            self::ACTION_FAVORITE => Yii::t('cons', 'ACTION_FAVORITE'),
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
     * @return array|mixed
     */
    public static function getActionProfileField($id = null, $all = false, $flip = false)
    {
        $data = [
            self::ACTION_LIKE => 'like',
            self::ACTION_HATE => 'hate',
            self::ACTION_FOLLOW => 'follow',
            self::ACTION_THANKS => 'thanks',
            self::ACTION_FAVORITE => 'favorite',
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
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'target_id' => Yii::t('app', 'Target ID'),
            'name' => Yii::t('app', 'Name'),
            'action' => Yii::t('app', 'Action'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'target_id']);
    }

    /**
     * 判断动作是否存在
     * @param $action
     * @param $type
     * @param $targetId
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function hasAction($action, $type, $targetId)
    {
        return Yii::$app->user->isGuest ? null : self::find()->where([
            'action' => $action,
            'type' => $type,
            'target_id' => $targetId,
        ])->one();
    }
}
