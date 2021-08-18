<?php

namespace common\models\cms;

use common\models\base\Lang;
use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%cms_catalog}}" to add your code.
 *
 * @property Store $store
 * @property Page[] $cmsPages
 */
class CatalogBase extends BaseModel
{
    static $tableCode = 5001;

    static $mapLangFieldType = [
        'name' => 'text',
        'brief' => 'textarea',
        'content' => 'Ueditor',
    ];

    /**
     * 是否启用高并发，需要启用的在XxxBase中设置
     * @var bool
     */
    protected $highConcurrency = true;

    const KIND_NEWS = 1;
    const KIND_PRODUCT = 2;
    const KIND_GALLERY = 4;

    const TYPE_LIST = 'list';
    const TYPE_MENU = 'menu';
    const TYPE_LINK = 'link';

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

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getKindLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::KIND_NEWS => Yii::t('cons', 'KIND_NEWS'),
            self::KIND_PRODUCT => Yii::t('cons', 'KIND_PRODUCT'),
            self::KIND_GALLERY => Yii::t('cons', 'KIND_GALLERY'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getTypeLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::TYPE_LIST => Yii::t('cons', 'TYPE_LIST'),
            self::TYPE_MENU => Yii::t('cons', 'TYPE_MENU'),
            self::TYPE_LINK => Yii::t('cons', 'TYPE_LINK'),
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'is_nav' => Yii::t('app', 'Is Nav'),
            'banner' => Yii::t('app', 'Banner'),
            'banner_h5' => Yii::t('app', 'Banner H5'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keywords' => Yii::t('app', 'Seo Keywords'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'brief' => Yii::t('app', 'Brief'),
            'content' => Yii::t('app', 'Content'),
            'redirect_url' => Yii::t('app', 'Redirect Url'),
            'page_size' => Yii::t('app', 'Page Size'),
            'kind' => Yii::t('app', 'Kind'),
            'template' => Yii::t('app', 'Template'),
            'template_page' => Yii::t('app', 'Template Page'),
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
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['catalog_id' => 'id']);
    }

    public function getLanguages()
    {
        return $this->hasMany(Lang::className(), ['target_id' => 'id'])->where(['table_code' => static::getTableCode()]);
    }
}
