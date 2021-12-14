<?php

namespace common\models\base;

use common\models\BaseModel;
use common\models\Store;
use Yii;

/**
 * This is the model base class for table "{{%base_setting_type}}" to add your code.
 *
 * @property Store $store
 */
class SettingTypeBase extends BaseModel
{
    public $supportRoles = [];

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_DATE = 'date';
    const TYPE_DATETIME = 'datetime';
    const TYPE_DROP_DOWN_LIST = 'dropDownList';
    const TYPE_MULTIPLE_INPUT = 'multipleInput';
    const TYPE_RADIO_LIST = 'radioList';
    const TYPE_CHECKBOX_LIST = 'checkboxList';
    const TYPE_BAIDU_UEDITOR = 'baiduUEditor';
    const TYPE_IMAGE = 'image';
    const TYPE_IMAGES = 'images';
    const TYPE_FILE = 'file';
    const TYPE_FILES = 'files';
    const TYPE_CROPPER = 'cropper';
    const TYPE_LAT_LNG_SELECTION = 'latLngSelection';

    const SUPPORT_ROLE_SUPER_ADMIN = 1;
    const SUPPORT_ROLE_ADMIN = 2;
    const SUPPORT_ROLE_STORE = 4;
    const SUPPORT_ROLE_FRONTEND = 8;

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
            self::TYPE_TEXT => Yii::t('cons', 'TYPE_TEXT'),
            self::TYPE_TEXTAREA => Yii::t('cons', 'TYPE_TEXTAREA'),
            self::TYPE_DATE => Yii::t('cons', 'TYPE_DATE'),
            self::TYPE_DATETIME => Yii::t('cons', 'TYPE_DATETIME'),
            self::TYPE_DROP_DOWN_LIST => Yii::t('cons', 'TYPE_DROP_DOWN_LIST'),
            self::TYPE_MULTIPLE_INPUT => Yii::t('cons', 'TYPE_MULTIPLE_INPUT'),
            self::TYPE_RADIO_LIST => Yii::t('cons', 'TYPE_RADIO_LIST'),
            self::TYPE_CHECKBOX_LIST => Yii::t('cons', 'TYPE_CHECKBOX_LIST'),
            self::TYPE_BAIDU_UEDITOR => Yii::t('cons', 'TYPE_BAIDU_UEDITOR'),
            self::TYPE_IMAGE => Yii::t('cons', 'TYPE_IMAGE'),
            self::TYPE_IMAGES => Yii::t('cons', 'TYPE_IMAGES'),
            self::TYPE_FILE => Yii::t('cons', 'TYPE_FILE'),
            self::TYPE_FILES => Yii::t('cons', 'TYPE_FILES'),
            self::TYPE_CROPPER => Yii::t('cons', 'TYPE_CROPPER'),
            self::TYPE_LAT_LNG_SELECTION => Yii::t('cons', 'TYPE_LAT_LNG_SELECTION'),
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
    public static function getSupportRoleLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::SUPPORT_ROLE_SUPER_ADMIN => Yii::t('cons', 'SUPPORT_ROLE_SUPER_ADMIN'),
            self::SUPPORT_ROLE_ADMIN => Yii::t('cons', 'SUPPORT_ROLE_ADMIN'),
            self::SUPPORT_ROLE_STORE => Yii::t('cons', 'SUPPORT_ROLE_STORE'),
            self::SUPPORT_ROLE_FRONTEND => Yii::t('cons', 'SUPPORT_ROLE_FRONTEND'),
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
    public static function getSupportSystemLabels($id = null, $all = false, $flip = false)
    {
        $data = [];
        foreach (Yii::$app->params['routeCode'] as $k => $v) {
            $data[$k] = Yii::t('cons', Yii::$app->params['routes'][$k]);
        }

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
            'app_id' => Yii::t('app', 'App ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'brief' => Yii::t('app', 'Brief'),
            'type' => Yii::t('app', 'Type'),
            'value_range' => Yii::t('app', 'Value Range'),
            'value_default' => Yii::t('app', 'Value Default'),
            'support_role' => Yii::t('app', 'Support Role'),
            'supportRoles' => Yii::t('app', 'Support Role'),
            'support_system' => Yii::t('app', 'Support System'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ]);
    }

    /**
     * 获取配置
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Setting::class, ['setting_type_id' => 'id'])
            ->where(['status' => Setting::STATUS_ACTIVE])
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC]);
    }

}
