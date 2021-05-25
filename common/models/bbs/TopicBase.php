<?php

namespace common\models\bbs;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model base class for table "{{%bbs_topic}}" to add your code.
 *
 * @property Tag[] $bbsTags
 * @property Node $node
 * @property TopicTag[] $bbsTopicTags
 */
class TopicBase extends BaseModel
{
    const FORMAT_HTML = 1;
    const FORMAT_MARKDOWN = 2;

    const GRADE_NORMAL = 0;
    const GRADE_EXCELLENT = 1;

    const SOURCE_WEIXIN = 'SourceWeixin';

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['node_id'], 'exist', 'skipOnError' => true, 'targetClass' => Node::className(), 'targetAttribute' => ['node_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        // 未登录认为是store管理员登录, console下不一定有Yii::$app->user
        $userId = isset(Yii::$app->user) && !Yii::$app->user->getIsGuest() ? Yii::$app->user->id : Yii::$app->storeSystem->getUserId();
        return [
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
                'value' => $userId,
            ],
        ];
    }

    /** add function getXxxLabels here, detail in BaseModel **/

    public static function getKindLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::GRADE_NORMAL => Yii::t('cons', 'GRADE_NORMAL'),
            self::GRADE_EXCELLENT => Yii::t('cons', 'GRADE_EXCELLENT'),
        ];

        $all && $data += [
        ];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    public static function getFormatLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::FORMAT_HTML => Yii::t('cons', 'FORMAT_HTML'),
            self::FORMAT_MARKDOWN => Yii::t('cons', 'FORMAT_MARKDOWN'),
        ];

        $all && $data += [
        ];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    public static function getSourceLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::SOURCE_WEIXIN => Yii::t('cons', 'SOURCE_WEIXIN'),
        ];

        $all && $data += [
        ];

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
            'node_id' => Yii::t('app', 'Node ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
            'name' => Yii::t('app', 'Name'),
            'thumb' => Yii::t('app', 'Thumb'),
            'images' => Yii::t('app', 'Images'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keywords' => Yii::t('app', 'Seo Keywords'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'meta' => Yii::t('app', 'Meta'),
            'brief' => Yii::t('app', 'Brief'),
            'content' => Yii::t('app', 'Content'),
            'price' => Yii::t('app', 'Price'),
            'redirect_url' => Yii::t('app', 'Redirect Url'),
            'template' => Yii::t('app', 'Template'),
            'click' => Yii::t('app', 'Click'),
            'like' => Yii::t('app', 'Like'),
            'comment' => Yii::t('app', 'Comment'),
            'is_comment' => Yii::t('app', 'Is Comment'),
            'category' => Yii::t('app', 'Category'),
            'kind' => Yii::t('app', 'Kind'),
            'grade' => Yii::t('app', 'Grade'),
            'format' => Yii::t('app', 'Format'),
            'user_id' => Yii::t('app', 'User ID'),
            'username' => Yii::t('app', 'Username'),
            'user_avatar' => Yii::t('app', 'User Avatar'),
            'last_comment_username' => Yii::t('app', 'Last Comment Username'),
            'last_comment_user_id' => Yii::t('app', 'Last Comment User ID'),
            'last_comment_updated_at' => Yii::t('app', 'Last Comment Updated At'),
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
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicMetas()
    {
        return $this->hasMany(TopicMeta::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNode()
    {
        return $this->hasOne(Node::className(), ['id' => 'node_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicTags()
    {
        return $this->hasMany(TopicTag::className(), ['topic_id' => 'id']);
    }

    public function getLike()
    {
        return UserAction::hasAction(UserAction::ACTION_LIKE, UserAction::TYPE_TOPIC, $this->id);
    }

    public function getHate()
    {
        return UserAction::hasAction(UserAction::ACTION_HATE, UserAction::TYPE_TOPIC, $this->id);
    }

    public function getFollow()
    {
        return UserAction::hasAction(UserAction::ACTION_FOLLOW, UserAction::TYPE_TOPIC, $this->id);
    }

    public function getThanks()
    {
        return UserAction::hasAction(UserAction::ACTION_THANKS, UserAction::TYPE_TOPIC, $this->id);
    }

    public function getFavorite()
    {
        return UserAction::hasAction(UserAction::ACTION_FAVORITE, UserAction::TYPE_TOPIC, $this->id);
    }
}
