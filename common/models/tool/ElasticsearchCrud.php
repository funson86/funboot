<?php

namespace common\models\tool;

use common\components\behaviors\StoreBehavior;
use Yii;
use common\models\User;
use common\models\Store;

/**
 * This is the model class for Elasticsearch.
 *
 * @property int $id
 * @property int $store_id 商家
 * @property string $name 名称
 * @property int $type 类型
 * @property int $sort 排序
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $created_by 创建用户
 * @property int $updated_by 更新用户
 */
class ElasticsearchCrud extends ElasticsearchCrudBase
{
    use StoreBehavior;

    /**
     * @return null|object|\yii\elasticsearch\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('elasticsearch');
    }

    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function index()
    {
        return 'funboot';
    }

    /**
     * 表名
     *
     * @return string
     */
    public static function type()
    {
        return 'curd';
    }

    /**
     * @return array This model's mapping
     */
    public static function mapping()
    {
        return [
            // Field types: https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html#field-datatypes
            'properties' => [
                'id' => ['type' => 'long'],
                'store_id' => ['type' => 'long'],
                'name' => ['type' => 'text'],
                'type' => ['type' => 'integer'],
                'sort' => ['type' => 'integer'],
                'status' => ['type' => 'integer'],
                'created_at' => ['type' => 'long'],
                'updated_at' => ['type' => 'long'],
                'created_by' => ['type' => 'long'],
                'updated_by' => ['type' => 'long'],
            ]
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        if (!$command->indexExists(self::index())) {
            $command->createIndex(self::index());
        }

        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Create this model's index
     */
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            //'aliases' => [ /* ... */ ],
            'mappings' => static::mapping(),
            //'settings' => [ /* ... */ ],
        ]);
    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['store_id', 'type', 'sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ]);
    }

    public function attributes()
    {
        return array_keys($this->attributeLabels());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        if (Yii::$app->language == Yii::$app->params['sqlCommentLanguage']) {
            return array_merge(parent::attributeLabels(), [
                '_id' => Yii::t('app', 'ID'),
                'store_id' => '商家',
                'name' => '名称',
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
                '_id' => Yii::t('app', 'ID'),
                'store_id' => Yii::t('app', 'Store ID'),
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
    }
}
