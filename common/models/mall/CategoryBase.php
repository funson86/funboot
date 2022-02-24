<?php

namespace common\models\mall;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%mall_category}}" to add your code.
 *
 * @property Store $store
 */
class CategoryBase extends BaseModel
{
    static $tableCode = 2480;

    static $mapLangFieldType = [
        'name' => 'text',
        'brief' => 'textarea',
        'redirect_url' => 'text',
    ];

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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'brief' => Yii::t('app', 'Brief'),
            'is_nav' => Yii::t('app', 'Is Nav'),
            'banner' => Yii::t('app', 'Banner'),
            'seo_url' => Yii::t('app', 'Seo Url'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keywords' => Yii::t('app', 'Seo Keywords'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'redirect_url' => Yii::t('app', 'Redirect Url'),
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
     * Get all catalog order by parent/child with the space before child label
     * Usage: ArrayHelper::map(Catalog::get(0, Catalog::find()->asArray()->all()), 'id', 'label')
     * @param int $parentId  parent catalog id
     * @param array $array  catalog array list
     * @param int $level  catalog level, will affect $repeat
     * @param int $add  times of $repeat
     * @param string $repeat  symbols or spaces to be added for sub catalog
     * @return array  catalog collections
     */
    static public function get($parentId = 0, $array = [], $level = 0, $add = 2, $repeat = '　')
    {
        $strRepeat = '';
        // add some spaces or symbols for non top level categories
        if ($level > 1) {
            for ($j = 0; $j < $level; $j++) {
                $strRepeat .= $repeat;
            }
        }

        $newArray = array ();
        //performance is not very good here
        foreach ((array)$array as $v) {
            if ($v['parent_id'] == $parentId) {
                $item = (array)$v;
                $item['label'] = $strRepeat . (isset($v['title']) ? $v['title'] : $v['name']);
                $newArray[] = $item;

                $tempArray = self::get($v['id'], $array, ($level + $add), $add, $repeat);
                if ($tempArray) {
                    $newArray = array_merge($newArray, $tempArray);
                }
            }
        }
        return $newArray;
    }

    /**
     * Get all children id as a array
     * Usage:
     * $ids = Catalog::getCatalogIdStr($id, CmsCatalog::find()->asArray()->all());
     * $shows = CmsShow::find()->where(['catalog_id' => $ids,])->all();
     * @param int $parentId  parent catalog id
     * @param array $array  catalog array list
     * @return array  catalog Id collections. eg: [2, 3, 7, 8]
     */
    static public function getArraySubCatalogId($parentId = 0, $array = [])
    {
        $result[] = $parentId;
        foreach ((array)$array as $v) {
            if ($v['parent_id'] == $parentId) {
                $tempResult = self::getArraySubCatalogId($v['id'], $array);
                if ($tempResult) {
                    $result = array_merge($result, $tempResult);
                }
            }
        }
        return $result;
    }

    /**
     * Get the root catalog id
     * Usage: $rootId = Catalog::getArraySubCatalogId($id, Catalog::find()->asArray()->all());
     * @param int $id  parent catalog id
     * @param array $array  catalog array list
     * @return int root catalog id
     */
    static public function getRootCatalogId($id = 0, $array = [])
    {
        if (0 == $id)
            return 0;

        foreach ((array)$array as $v) {
            if ($v['id'] == $id) {
                $parentId = $v['parent_id'];
                if(0 == $parentId)
                    return $id;
                else
                    return self::getRootCatalogId($parentId, $array);
            }
        }
    }

    /**
     * Get all children id as a array
     * Usage:
     * $ids = Catalog::getCatalogIdStr($id, CmsCatalog::find()->asArray()->all());
     * $shows = CmsShow::find()->where(['catalog_id' => $ids,])->all();
     * @param int $parentId  parent catalog id
     * @param array $array  catalog array list
     * @return array  catalog Id collections. eg: [2, 3, 7, 8]
     */
    static public function getCatalogPath($id = 0, $array = [])
    {
        if (0 == $id)
            return [];

        $result = [];
        $tmpId = $id;
        while ($tmpId > 0) {
            array_push($result, $tmpId);
            $tmpId = self::getCatalogParentId($tmpId, $array);
        }

        return array_reverse($result);

        /*foreach ((array)$array as $v) {
            if ($v['id'] == $id) {
                if ($v['parent_id'] == 0) {
                    array_push($result, $id);
                } else {
                    $result = self::getCatalogPath($v['parent_id'], $array);
                }
            }
            if ($v['parent_id'] == $id) {
                $tempResult = self::getArraySubCatalogId($v['id'], $array);
                if ($tempResult) {
                    $result = array_merge($result, $tempResult);
                }
            }
        }
        return $result;*/
    }

    /**
     * Get all children id as a array
     * Usage:
     * $ids = Catalog::getCatalogIdStr($id, CmsCatalog::find()->asArray()->all());
     * $shows = CmsShow::find()->where(['catalog_id' => $ids,])->all();
     * @param int $parentId  parent catalog id
     * @param array $array  catalog array list
     * @return array  catalog Id collections. eg: [2, 3, 7, 8]
     */
    static public function getCatalogParentId($id = 0, $array = [])
    {
        if (0 == $id)
            return 0;

        foreach ((array)$array as $v) {
            if ($v['id'] == $id) {
                return (int)$v['parent_id'];
            }
        }

        return false;
    }

    /**
     * Get the root catalog id, then get the sub catalog of the root calalog
     * Usage: $rootId = Catalog::getArraySubCatalogId($id, Catalog::find()->asArray()->all());
     * @param int $id  parent catalog id
     * @param array $array  catalog array list
     * @return array  the sub catalog of root catalog Id collections.
     */
    static public function getRootCatalogSub2($id = 0, $array = [])
    {
        $arrayResult = array();
        $rootId = self::getRootCatalogId($id, $array);
        foreach ((array)$array as $v) {
            if ($v['parent_id'] == $rootId) {
                array_push($arrayResult, $v);
            }
        }

        return $arrayResult;
    }

}
