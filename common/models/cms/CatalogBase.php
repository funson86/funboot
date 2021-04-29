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
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'is_nav' => Yii::t('app', 'Is Nav'),
            'banner' => Yii::t('app', 'Banner'),
            'banner_h5' => Yii::t('app', 'Banner H5'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keywords' => Yii::t('app', 'Seo Keywords'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'content' => Yii::t('app', 'Content'),
            'redirect_url' => Yii::t('app', 'Redirect Url'),
            'page_size' => Yii::t('app', 'Page Size'),
            'template' => Yii::t('app', 'Template'),
            'template_page' => Yii::t('app', 'Template Page'),
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
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['catalog_id' => 'id']);
    }

    public function getLanguages()
    {
        return $this->hasMany(Lang::className(), ['target_id' => 'id'])->where(['table_code' => static::getTableCode()]);
    }
}
