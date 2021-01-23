<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\tool\Crud as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\tool\Crud */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Crud');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cruds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <div class="col-sm-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description')->textarea() ?>
                    <?= $form->field($model, 'time')->widget(kartik\time\TimePicker::class, [
                        'language' => 'zh-CN',
                        'pluginOptions' => [
                            'showSeconds' => true
                        ]
                    ]) ?>
                    <?= $form->field($model, 'date')->widget(kartik\date\DatePicker::class, [
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
                    ]) ?>
                    <?= $form->field($model, 'started_at')->widget(kartik\datetime\DateTimePicker::class, [
                        'language' => 'zh-CN',
                        'options' => [
                            'value' => $model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', $model->started_at),
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii:ss',
                            'todayHighlight' => true, // 今日高亮
                            'autoclose' => true, // 选择后自动关闭
                            'todayBtn' => true, // 今日按钮显示
                        ]
                    ]) ?>
                    <?= $form->field($model, 'ended_at')->widget(kartik\datetime\DateTimePicker::class, [
                        'language' => 'zh-CN',
                        'options' => [
                            'value' => $model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', $model->ended_at),
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii:ss',
                            'todayHighlight' => true, // 今日高亮
                            'autoclose' => true, // 选择后自动关闭
                            'todayBtn' => true, // 今日按钮显示
                        ]
                    ]) ?>
                    <?= $form->field($model, 'color')->widget(\kartik\color\ColorInput::class, [
                        'options' => ['placeholder' => Yii::t('system', 'Please Select')],
                    ]); ?>
                    <?= $form->field($model, 'tag')->widget(kartik\select2\Select2::class, [
                        'data' => ['s1', 's2'], //传入变量
                        'options' => ['placeholder' => Yii::t('app', 'Please Select'), 'multiple' => 'multiple'],
                    ]) ?>
                    <?= $form->field($model, 'config')->widget(unclead\multipleinput\MultipleInput::class, [
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
                                'value' => function($data) {
                                    return $data['day'];
                                },
                                'items' => [
                                    '0' => 'Saturday',
                                    '1' => 'Monday'
                                ],
                                'options' => [
                                    'pluginOptions' => [
                                        'format' => 'yyyy-mm-dd',
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
                    ]) ?>
                    <?= $form->field($model, 'image')->widget(\common\components\uploader\FileWidget::class, [
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
                    ]); ?>
                    <?= $form->field($model, 'images')->widget(\common\components\uploader\FileWidget::class, [
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
                    ]); ?>
                    <?= $form->field($model, 'file')->widget(\common\components\uploader\FileWidget::class, [
                        'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_FILE,
                        'theme' => 'default',
                        'themeConfig' => [],
                        'config' => [
                            // 可设置自己的上传地址, 不设置则默认地址
                            // 'server' => '',
                            'pick' => [
                                'multiple' => false,
                            ],
                        ]
                    ]); ?>
                    <?= $form->field($model, 'files')->widget(\common\components\uploader\FileWidget::class, [
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
                    ]); ?>
                    <?= $form->field($model, 'content')->widget(\common\components\ueditor\Ueditor::class, []) ?>
                    <?= $form->field($model, 'type')->dropDownList(ActiveModel::getTypeLabels()) ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                </div>
            </div>
            <div class="card-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>