<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;

/**
 * This is the model base class for table "{{%base_lang}}" to add your code.
 *
 * @property Store $store
 */
class LangBase extends BaseModel
{
    const LANGUAGE_EN = 1 << 0;
    const LANGUAGE_ZH_CN = 1 << 1;
    const LANGUAGE_ZH_HK = 1 << 2;
    const LANGUAGE_FR = 1 << 3;
    const LANGUAGE_DE = 1 << 4;
    const LANGUAGE_RU = 1 << 5;
    const LANGUAGE_IT = 1 << 6;
    const LANGUAGE_ES = 1 << 7;
    const LANGUAGE_PT = 1 << 8;
    const LANGUAGE_TR = 1 << 9;
    const LANGUAGE_AR = 1 << 10;
    const LANGUAGE_JP = 1 << 11;
    const LANGUAGE_KO = 1 << 12;
    const LANGUAGE_NL = 1 << 13;
    const LANGUAGE_SV = 1 << 14;

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
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getLanguageLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::LANGUAGE_EN => Yii::t('cons', 'LANGUAGE_EN'),
            self::LANGUAGE_ZH_CN => Yii::t('cons', 'LANGUAGE_ZH_CN'),
            self::LANGUAGE_ZH_HK => Yii::t('cons', 'LANGUAGE_ZH_HK'),
            self::LANGUAGE_FR => Yii::t('cons', 'LANGUAGE_FR'),
            self::LANGUAGE_DE => Yii::t('cons', 'LANGUAGE_DE'),
            self::LANGUAGE_RU => Yii::t('cons', 'LANGUAGE_RU'),
            self::LANGUAGE_IT => Yii::t('cons', 'LANGUAGE_IT'),
            self::LANGUAGE_ES => Yii::t('cons', 'LANGUAGE_ES'),
            self::LANGUAGE_PT => Yii::t('cons', 'LANGUAGE_PT'),
            self::LANGUAGE_TR => Yii::t('cons', 'LANGUAGE_TR'),
            self::LANGUAGE_AR => Yii::t('cons', 'LANGUAGE_AR'),
            self::LANGUAGE_JP => Yii::t('cons', 'LANGUAGE_JP'),
            self::LANGUAGE_KO => Yii::t('cons', 'LANGUAGE_KO'),
            self::LANGUAGE_NL => Yii::t('cons', 'LANGUAGE_NL'),
            self::LANGUAGE_SV => Yii::t('cons', 'LANGUAGE_SV'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            $str = '';
            foreach ($data as $k => $v) {
                if (($id & $k) == $k) {
                    $str .= $data[$k] . ' ';
                }
            }
            return $str;
        }
        return $data;
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @param bool $isArray
     * @return array|mixed|null
     */
    public static function getLanguageCode($id = null, $all = false, $flip = false, $isArray = false)
    {
        $data = [
            self::LANGUAGE_EN => 'en',
            self::LANGUAGE_ZH_CN => 'zh-CN',
            self::LANGUAGE_ZH_HK => 'zh-HK',
            self::LANGUAGE_FR => 'fr',
            self::LANGUAGE_DE => 'de',
            self::LANGUAGE_RU => 'ru',
            self::LANGUAGE_IT => 'it',
            self::LANGUAGE_ES => 'es',
            self::LANGUAGE_PT => 'pt',
            self::LANGUAGE_TR => 'tr',
            self::LANGUAGE_AR => 'ar',
            self::LANGUAGE_JP => 'jp',
            self::LANGUAGE_KO => 'ko',
            self::LANGUAGE_NL => 'nl',
            self::LANGUAGE_SV => 'sv',
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            $arr = [];
            foreach ($data as $k => $v) {
                if (($id & $k) == $k) {
                    $arr[] = $data[$k];
                }
            }
            return $isArray ? $arr : $arr[0];
        }

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getLanguageBaiduCode($id = null, $all = false, $flip = false)
    {
        $data = [
            self::LANGUAGE_EN => 'en',
            self::LANGUAGE_ZH_CN => 'zh',
            self::LANGUAGE_ZH_HK => 'cht',
            self::LANGUAGE_FR => 'fra',
            self::LANGUAGE_DE => 'de',
            self::LANGUAGE_RU => 'ru',
            self::LANGUAGE_IT => 'it',
            self::LANGUAGE_ES => 'spa',
            self::LANGUAGE_PT => 'pt',
            self::LANGUAGE_TR => 'tr',
            self::LANGUAGE_AR => 'ara',
            self::LANGUAGE_JP => 'jp',
            self::LANGUAGE_KO => 'kor',
            self::LANGUAGE_NL => 'nl',
            self::LANGUAGE_SV => 'swe',
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * @param null $id
     * @param bool $all
     * @param bool $flip
     * @return array|mixed|null
     */
    public static function getLanguageFlag($id = null, $all = false, $flip = false)
    {
        $data = [
            self::LANGUAGE_EN => 'gb',
            self::LANGUAGE_ZH_CN => 'cn',
            self::LANGUAGE_ZH_HK => 'hk',
            self::LANGUAGE_FR => 'fr',
            self::LANGUAGE_DE => 'de',
            self::LANGUAGE_RU => 'ru',
            self::LANGUAGE_IT => 'it',
            self::LANGUAGE_ES => 'es',
            self::LANGUAGE_PT => 'pt',
            self::LANGUAGE_TR => 'tr',
            self::LANGUAGE_AR => 'ar',
            self::LANGUAGE_JP => 'jp',
            self::LANGUAGE_KO => 'kr',
            self::LANGUAGE_NL => 'nl',
            self::LANGUAGE_SV => 'sv',
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
            'name' => Yii::t('app', 'Name'),
            'source' => Yii::t('app', 'Source'),
            'target' => Yii::t('app', 'Target'),
            'table_code' => Yii::t('app', 'Table Code'),
            'target_id' => Yii::t('app', 'Target ID'),
            'content' => Yii::t('app', 'Content'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

}
