<?php

namespace common\models\base;

use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for table "{{%base_profile}}".
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property string $company 公司
 * @property string $location 城市
 * @property int $topic 主题数
 * @property int $like 点赞数
 * @property int $hate 倒彩数
 * @property int $thanks 感谢数
 * @property int $follow 关注数
 * @property int $click 浏览
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class Profile extends ProfileBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'topic', 'like', 'hate', 'thanks', 'follow', 'click', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'company', 'location'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        if (Yii::$app->language == Yii::$app->params['sqlCommentLanguage']) {
            return array_merge(parent::attributeLabels(), [
                'id' => Yii::t('app', 'ID'),
                'store_id' => '商家',
                'name' => '名称',
                'company' => '公司',
                'location' => '城市',
                'topic' => '主题数',
                'like' => '点赞数',
                'hate' => '倒彩数',
                'thanks' => '感谢数',
                'follow' => '关注数',
                'click' => '浏览',
                'type' => '类型',
                'sort' => '排序',
                'status' => '状态',
                'created_at' => '创建时间',
                'updated_at' => '更新时间',
                'created_by' => '创建用户',
                'updated_by' => '更新用户',
            ]);
        } else {
            return array_merge(parent::attributeLabels(), [
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
            ]);
        }
    }
}
