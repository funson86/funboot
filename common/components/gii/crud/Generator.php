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
            'text' => "文本框",
            'textarea' => "文本域",
            'time' => "时间",
            'date' => "日期",
            'datetime' => "日期时间",
            'dropDownList' => "下拉选择框",
            'multipleInput' => "Input组",
            'radioList' => "单选按钮",
            'checkboxList' => "复选框",
            'baiduUEditor' => "百度编辑器",
            'image' => "图片上传",
            'images' => "多图上传",
            'file' => "文件上传",
            'files' => "多文件上传",
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
     * @return string
     */
    public function generateActiveField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        $type = $this->inputType[$attribute] ?? '';

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
                            'options' => ['placeholder' => '请选择颜色'],
                    ]);";
                break;
            case 'time':
                return "\$form->field(\$model, '$attribute')->widget(kartik\\time\TimePicker::class, [
                        'language' => 'zh-CN',
                        'pluginOptions' => [
                            'showSeconds' => true
                        ]
                    ])";
                break;
            case 'date':
                return "\$form->field(\$model, '$attribute')->widget(kartik\date\DatePicker::class, [
                        'language' => 'zh-CN',
                        'layout'=>'{picker}{input}',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true, // 今日高亮
                            'autoclose' => true, // 选择后自动关闭
                            'todayBtn' => true, // 今日按钮显示
                        ],
                        'options'=>[
                            'class' => 'form-control no_bor',
                        ]
                    ])";
                break;
            case 'datetime':
                return "\$form->field(\$model, '$attribute')->widget(kartik\datetime\DateTimePicker::class, [
                        'language' => 'zh-CN',
                        'options' => [
                            'value' => \$model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', \$model->$attribute),
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii',
                            'todayHighlight' => true, // 今日高亮
                            'autoclose' => true, // 选择后自动关闭
                            'todayBtn' => true, // 今日按钮显示
                        ]
                    ])";
                break;
            case 'multipleInput':
                return "\$form->field(\$model, '$attribute')->widget(unclead\multipleinput\MultipleInput::class, [
                        'max' => 4,
                        'columns' => [
                            [
                                'name'  => 'user_id',
                                'type'  => 'dropDownList',
                                'title' => 'User',
                                'defaultValue' => 1,
                                'items' => [
                                   1 => 'User 1',
                                    2 => 'User 2'
                                ]
                            ],
                            [
                                'name'  => 'day',
                                'type'  => \kartik\date\DatePicker::class,
                                'title' => 'Day',
                                'value' => function(\$data) {
                                    return \$data['day'];
                                },
                                'items' => [
                                    '0' => 'Saturday',
                                    '1' => 'Monday'
                                ],
                                'options' => [
                                    'pluginOptions' => [
                                        'format' => 'dd.mm.yyyy',
                                        'todayHighlight' => true
                                    ]
                                ]
                            ],
                            [
                                'name'  => 'priority',
                                'title' => 'Priority',
                                'enableError' => true,
                                'options' => [
                                    'class' => 'input-priority'
                                ]
                            ]
                        ]
                     ])";
                break;
            case 'image':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\uploader\FileWidget::class, [
                        'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                        'theme' => 'default',
                        'themeConfig' => [],
                        'config' => [
                            // 可设置自己的上传地址, 不设置则默认地址
                            // 'server' => '',
                            'pick' => [
                                'multiple' => false,
                            ],
                        ]
                    ]);";
                break;
            case 'images':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\uploader\FileWidget::class, [
                        'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                        'theme' => 'default',
                        'themeConfig' => [],
                        'config' => [
                            // 可设置自己的上传地址, 不设置则默认地址
                            // 'server' => '',
                            'pick' => [
                                'multiple' => true,
                            ],
                        ]
                    ]);";
                break;
            case 'file':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\uploader\FileWidget::class, [
                        'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_FILE,
                        'theme' => 'default',
                        'themeConfig' => [],
                        'config' => [
                            // 可设置自己的上传地址, 不设置则默认地址
                            // 'server' => '',
                            'pick' => [
                                'multiple' => true,
                            ],
                        ]
                    ]);";
                break;
            case 'files':
                return "\$form->field(\$model, '$attribute')->widget(\common\components\uploader\FileWidget::class, [
                        'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_FILES,
                        'theme' => 'default',
                        'themeConfig' => [],
                        'config' => [
                            // 可设置自己的上传地址, 不设置则默认地址
                            // 'server' => '',
                            'pick' => [
                                'multiple' => true,
                            ],
                        ]
                    ]);";
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

        if (stripos($column->name, '_at') !== false && $column->phpType === 'integer') {
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