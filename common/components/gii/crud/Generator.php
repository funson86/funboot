<?php

namespace common\components\gii\crud;

use Yii;
use yii\helpers\Inflector;

/**
 * Class Generator
 * @package backend\components\gii\crud
 * @author funson86 <funson86@gmail.com>
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    public $listFields;
    public $formFields;
    public $inputType;

    /**
     * @return array
     */
    public function fieldTypes()
    {
        return [
            'text' => Yii::t('system', 'text'),
            'textarea' => Yii::t('system', 'textarea'),
            'time' => Yii::t('system', 'time'),
            'date' => Yii::t('system', 'date'),
            'datetime' => Yii::t('system', 'datetime'),
            'dropDownList' => Yii::t('system', 'dropDownList'),
            'color' => Yii::t('system', 'color'),
            'select2' => Yii::t('system', 'select2'),
            'multipleInput' => Yii::t('system', 'multipleInput'),
            'radioList' => Yii::t('system', 'radioList'),
            'checkboxList' => Yii::t('system', 'checkboxList'),
            'baiduUEditor' => Yii::t('system', 'baiduUEditor'),
            'image' => Yii::t('system', 'image'),
            'images' => Yii::t('system', 'images'),
            'file' => Yii::t('system', 'file'),
            'files' => Yii::t('system', 'files'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['listFields', 'formFields', 'inputType'], 'safe'],
        ]);
    }

    /**
     * Generates code for active field
     * @param string $attribute
     * @param bool $modal
     * @return string
     */
    public function generateActiveFieldFunboot($attribute, $modal = false)
    {
        $tableSchema = $this->getTableSchema();
        $type = $this->inputType[$attribute] ?? 'text';

        $blank = '        ';
        if (!$modal) {
            $blank = '                    ';
        }

        switch ($attribute) {
            case 'store_id':
                return "\$this->context->isAdmin() ? \$form->field(\$model, '$attribute')->dropDownList(\$this->context->getStoresIdName()) : ''";
                break;
            case 'parent_id':
                return "\$form->field(\$model, '$attribute')->dropDownList(ActiveModel::getTreeIdLabel())";
                break;
            case 'user_id':
                return "\$form->field(\$model, '$attribute')->dropDownList(\$this->context->getUsersIdName()) // \$form->field(\$model, '$attribute')->widget(kartik\select2\Select2::classname(), ['data' => \$this->context->getUsersIdName('email'), 'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => false],])";
                break;
            case 'type':
                return "\$form->field(\$model, '$attribute')->dropDownList(ActiveModel::get" . Inflector::camelize($attribute) . "Labels())";
                break;
            case 'status':
                return "\$form->field(\$model, '$attribute')->radioList(ActiveModel::get" . Inflector::camelize($attribute) . "Labels())";
                break;
        }

        switch ($type) {
            case 'text':
                return parent::generateActiveField($attribute);
                break;
            case 'textarea':
                return "\$form->field(\$model, '$attribute')->textarea()";
                break;
            case 'dropDownList':
                return "\$form->field(\$model, '$attribute')->dropDownList(ActiveModel::get" . Inflector::camelize($attribute) . "Labels())";
                break;
            case 'radioList':
                if ($attribute == 'status') {
                    return "\$form->field(\$model, '$attribute')->radioList(ActiveModel::get" . Inflector::camelize($attribute) . "Labels())";
                } else {
                    return "\$form->field(\$model, '$attribute')->radioList(YesNo::getLabels())";
                }
                break;
            case 'checkboxList':
                return "\$form->field(\$model, '$attribute')->checkboxList(ActiveModel::get" . Inflector::camelize($attribute) . "Labels())";
                break;
            case 'baiduUEditor':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\ueditor\Ueditor::class, [])";
                break;
            case 'color':
                return "\$form->field(\$model, '$attribute')->widget(\kartik\color\ColorInput::class, [
" . $blank . "    'options' => ['placeholder' => Yii::t('system', 'Please Select')],
" . $blank . "]);";
                break;
            case 'time':
                return "\$form->field(\$model, '$attribute')->widget(kartik\\time\TimePicker::class, [
" . $blank . "    'language' => 'zh-CN',
" . $blank . "    'pluginOptions' => [
" . $blank . "        'showSeconds' => true
" . $blank . "    ]
" . $blank . "])";
                break;
            case 'date':
                return "\$form->field(\$model, '$attribute')->widget(kartik\date\DatePicker::class, [
" . $blank . "    'language' => 'zh-CN',
" . $blank . "    'layout'=>'{picker}{input}',
" . $blank . "    'pluginOptions' => [
" . $blank . "        'format' => 'yyyy-mm-dd',
" . $blank . "        'todayHighlight' => true, // 今日高亮
" . $blank . "        'autoclose' => true, // 选择后自动关闭
" . $blank . "        'todayBtn' => true, // 今日按钮显示
" . $blank . "    ],
" . $blank . "    'options'=>[
" . $blank . "        'class' => 'form-control no_bor',
" . $blank . "    ]
" . $blank . "])";
                break;
            case 'datetime':
                return "\$form->field(\$model, '$attribute')->widget(kartik\datetime\DateTimePicker::class, [
" . $blank . "    'language' => 'zh-CN',
" . $blank . "    'options' => [
" . $blank . "        'value' => \$model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', \$model->$attribute),
" . $blank . "    ],
" . $blank . "    'pluginOptions' => [
" . $blank . "        'format' => 'yyyy-mm-dd hh:ii:ss',
" . $blank . "        'todayHighlight' => true, // 今日高亮
" . $blank . "        'autoclose' => true, // 选择后自动关闭
" . $blank . "        'todayBtn' => true, // 今日按钮显示
" . $blank . "    ]
" . $blank . "])";
                break;
            case 'select2':
                return "\$form->field(\$model, '$attribute')->widget(kartik\select2\Select2::class, [
" . $blank . "    'data' => ['s1', 's2'], //传入变量
" . $blank . "    'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
" . $blank . "])";
                break;
            case 'multipleInput':
                return "\$form->field(\$model, '$attribute')->widget(unclead\multipleinput\MultipleInput::class, [
" . $blank . "    'max' => 4,
" . $blank . "    'columns' => [
" . $blank . "        [
" . $blank . "            'name'  => 'user_id',
" . $blank . "            'type'  => 'dropDownList',
" . $blank . "            'title' => 'User',
" . $blank . "            'defaultValue' => 1,
" . $blank . "            'items' => [
" . $blank . "                1 => 'User 1',
" . $blank . "                2 => 'User 2'
" . $blank . "            ]
" . $blank . "        ],
" . $blank . "        [
" . $blank . "            'name'  => 'day',
" . $blank . "            'type'  => \kartik\date\DatePicker::class,
" . $blank . "            'title' => 'Day',
" . $blank . "            'value' => function(\$data) {
" . $blank . "                return \$data['day'];
" . $blank . "            },
" . $blank . "            'items' => [
" . $blank . "                '0' => 'Saturday',
" . $blank . "                '1' => 'Monday'
" . $blank . "            ],
" . $blank . "            'options' => [
" . $blank . "                'pluginOptions' => [
" . $blank . "                    'format' => 'yyyy-mm-dd',
" . $blank . "                    'todayHighlight' => true
" . $blank . "                ]
" . $blank . "            ]
" . $blank . "        ],
" . $blank . "        [
" . $blank . "            'name'  => 'priority',
" . $blank . "            'title' => 'Priority',
" . $blank . "            'enableError' => true,
" . $blank . "            'options' => [
" . $blank . "                'class' => 'input-priority'
" . $blank . "            ]
" . $blank . "        ]
" . $blank . "    ]
" . $blank . "])";
                break;
            case 'image':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\uploader\FileWidget::class, [
" . $blank . "    'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
" . $blank . "    'theme' => 'default',
" . $blank . "    'themeConfig' => [],
" . $blank . "    'config' => [
" . $blank . "        // 可设置自己的上传地址, 不设置则默认地址
" . $blank . "        // 'server' => '',
" . $blank . "        'pick' => [
" . $blank . "            'multiple' => false,
" . $blank . "        ],
" . $blank . "    ]
" . $blank . "]);";
                break;
            case 'images':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\uploader\FileWidget::class, [
" . $blank . "    'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
" . $blank . "    'theme' => 'default',
" . $blank . "    'themeConfig' => [],
" . $blank . "    'config' => [
" . $blank . "        // 可设置自己的上传地址, 不设置则默认地址
" . $blank . "        // 'server' => '',
" . $blank . "        'pick' => [
" . $blank . "            'multiple' => true,
" . $blank . "        ],
" . $blank . "    ]
" . $blank . "]);";
                break;
            case 'file':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\uploader\FileWidget::class, [
" . $blank . "    'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_FILE,
" . $blank . "    'theme' => 'default',
" . $blank . "    'themeConfig' => [],
" . $blank . "    'config' => [
" . $blank . "        // 可设置自己的上传地址, 不设置则默认地址
" . $blank . "        // 'server' => '',
" . $blank . "        'pick' => [
" . $blank . "            'multiple' => false,
" . $blank . "        ],
" . $blank . "    ]
" . $blank . "]);";
                break;
            case 'files':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\uploader\FileWidget::class, [
" . $blank . "    'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_FILE,
" . $blank . "    'theme' => 'default',
" . $blank . "    'themeConfig' => [],
" . $blank . "    'config' => [
" . $blank . "        // 可设置自己的上传地址, 不设置则默认地址
" . $blank . "        // 'server' => '',
" . $blank . "        'pick' => [
" . $blank . "            'multiple' => true,
" . $blank . "        ],
" . $blank . "    ]
" . $blank . "]);";
                break;
        }
    }


    /**
     * Generates column format
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat($column)
    {
        if ($column->phpType === 'boolean') {
            return 'boolean';
        }

        if ($column->type === 'text') {
            return 'ntext';
        }

        if ($column->type === 'json') {
            return 'json';
        }

        if (stripos($column->name, '_at') !== false && $column->phpType === 'integer') {
            return 'datetime';
        }

        if (stripos($column->name, 'time') !== false && $column->phpType === 'integer') {
            return 'datetime';
        }

        if (stripos($column->name, 'email') !== false) {
            return 'email';
        }

        if (preg_match('/(\b|[_-])url(\b|[_-])/i', $column->name)) {
            return 'url';
        }

        return 'text';
    }
}