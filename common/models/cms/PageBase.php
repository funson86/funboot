<?php

namespace common\models\cms;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%cms_page}}" to add your code.
 *
 * @property Catalog $catalog
 * @property Store $store
 */
class PageBase extends BaseModel
{
    static $tableCode = 5003;

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

    const FORMAT_HTML = 1;
    const FORMAT_MARKDOWN = 2;
    const FORMAT_TEXTAREA = 4;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /** add function getXxxLabels here, detail in BaseModel **/

    public static function getFormatLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::FORMAT_HTML => Yii::t('cons', 'FORMAT_HTML'),
            self::FORMAT_MARKDOWN => Yii::t('cons', 'FORMAT_MARKDOWN'),
            self::FORMAT_TEXTAREA => Yii::t('cons', 'FORMAT_TEXTAREA'),
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
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'banner' => Yii::t('app', 'Banner'),
            'banner_h5' => Yii::t('app', 'Banner H5'),
            'thumb' => Yii::t('app', 'Thumb'),
            'images' => Yii::t('app', 'Images'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keywords' => Yii::t('app', 'Seo Keywords'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'brief' => Yii::t('app', 'Brief'),
            'content' => Yii::t('app', 'Content'),
            'price' => Yii::t('app', 'Price'),
            'redirect_url' => Yii::t('app', 'Redirect Url'),
            'kind' => Yii::t('app', 'Kind'),
            'format' => Yii::t('app', 'Format'),
            'template' => Yii::t('app', 'Template'),
            'click' => Yii::t('app', 'Click'),
            'param1' => Yii::t('app', 'Param1'),
            'param2' => Yii::t('app', 'Param2'),
            'param3' => Yii::t('app', 'Param3'),
            'param4' => Yii::t('app', 'Param4'),
            'param5' => Yii::t('app', 'Param5'),
            'param6' => Yii::t('app', 'Param6'),
            'param7' => Yii::t('app', 'Param7'),
            'param8' => Yii::t('app', 'Param8'),
            'param9' => Yii::t('app', 'Param9'),
            'param10' => Yii::t('app', 'Param10'),
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
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }


}
