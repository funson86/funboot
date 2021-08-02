<?php

namespace common\models\forms\tool;

use Da\QrCode\Contracts\ErrorCorrectionLevelInterface;
use yii\base\Model;
use Yii;

/**
 * Class QrForm
 * @package common\models\forms\tool
 * @author funson86 <funson86@gmail.com>
 */
class QrForm extends Model
{
    public $content;
    public $size = 200;
    public $margin = 10;
    public $background = '#FFFFFF';
    public $foreground = '#000000';
    public $logo;
    public $logoSize = 50;
    public $label = 'Fb System';
    public $labelSize = 13;
    public $labelAlign = 'center';
    public $correctionLevel = ErrorCorrectionLevelInterface::LOW;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'size', 'foreground', 'background'], 'required'],
            [['labelSize', 'size', 'margin', 'logoSize'], 'integer', 'min' => 0],
            [['content', 'label', 'correctionLevel', 'labelAlign', 'logo', 'foreground', 'background'], 'string'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        if (Yii::$app->language == Yii::$app->params['sqlCommentLanguage']) {
            return array_merge(parent::attributeLabels(), [
                'content' => '文本内容',
                'size' => '大小',
                'margin' => '内边距',
                'logo' => 'Logo',
                'logoSize' => 'Logo大小',
                'correctionLevel' => '容错级别',
                'label' => '标签',
                'labelSize' => '标签大小',
                'labelAlign' => '标签位置',
                'foreground' => '前景色',
                'background' => '背景色',
            ]);
        } else {
            return array_merge(parent::attributeLabels(), [
                'content' => Yii::t('app', 'Content'),
                'size' => Yii::t('app', 'Size'),
                'margin' => Yii::t('app', 'Margin'),
                'logo' => Yii::t('app', 'Logo'),
                'logoSize' => Yii::t('app', 'Logo Size'),
                'correctionLevel' => Yii::t('app', 'Correction Level'),
                'label' => Yii::t('app', 'Label'),
                'labelSize' => Yii::t('app', 'Label Size'),
                'labelLocation' => Yii::t('app', 'Label Location'),
                'foreground' => Yii::t('app', 'Foreground'),
                'background' => Yii::t('app', 'Background'),
            ]);
        }
    }


    /**
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getCorrectionLevelLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            ErrorCorrectionLevelInterface::LOW => Yii::t('cons', 'low'),
            ErrorCorrectionLevelInterface::MEDIUM => Yii::t('cons', 'medium'),
            ErrorCorrectionLevelInterface::QUARTILE => Yii::t('cons', 'quartile'),
            ErrorCorrectionLevelInterface::HIGH => Yii::t('cons', 'high'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }
}