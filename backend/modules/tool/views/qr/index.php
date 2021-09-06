<?php

use yii\widgets\ActiveForm;
use common\helpers\Html;
use common\models\forms\tool\QrForm as ActiveModel;
use frontend\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \common\models\forms\tool\QrForm */

$this->title = Yii::t('app', 'Qr Code');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'qr',
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'content')->textInput(); ?>
                            <?= $form->field($model, 'size')->textInput(); ?>
                            <?= $form->field($model, 'margin')->textInput(); ?>
                            <?= $form->field($model, 'correctionLevel')->radioList(ActiveModel::getCorrectionLevelLabels()); ?>
                            <?= $form->field($model, 'foreground')->widget(kartik\color\ColorInput::class, [
                                'options' => [
                                    'placeholder' => Yii::t('app', 'Please Select'),
                                    'readonly' => true
                                ],
                            ]);?>
                            <?= $form->field($model, 'background')->widget(kartik\color\ColorInput::class, [
                                'options' => [
                                    'placeholder' => Yii::t('app', 'Please Select'),
                                    'readonly' => true
                                ],
                            ]);?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'logo')->widget(\common\components\uploader\FileWidget::class, [
                                'uploadType' => \common\models\base\Attachment::UPLOAD_TYPE_IMAGE,
                                'theme' => 'default',
                                'themeConfig' => ['select' => false,],
                                'config' => [
                                    // 可设置自己的上传地址, 不设置则默认地址
                                    // 'server' => '',
                                    'accept' => [
                                        'extensions' => ['png', 'jpeg', 'jpg'],
                                    ],
                                    'pick' => [
                                        'multiple' => false,
                                    ],
                                    'fileSingleSizeLimit' => 1024 * 500,// 图片大小限制
                                    'independentUrl' => true,
                                ],
                            ])->hint('只支持 png/jpeg/jpg 格式,大小不超过为500K'); ?>
                            <?= $form->field($model, 'logoSize')->textInput(); ?>
                            <?= $form->field($model, 'label')->textInput(); ?>
                            <?= $form->field($model, 'labelSize')->textInput(); ?>
                            <?= $form->field($model, 'labelAlign')->radioList([
                                'left' => '左边',
                                'center' => '居中',
                                'right' => '右边',
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?= Html::button(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'id' => 'create']) ?>
                    <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-group text-center align-items-center">
                            <img src="" id="qrSrc">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<script>
    $('#create').click(function () {
        let params = $('#qr').serializeArray();
        let len = params.length;

        let str = '';
        for (let i = 0; i < len; i++) {
            str += params[i]['name'] + '=' + params[i]['value'] + '&';
        }

        str = str.replace(/\#/g, "%23");
        var url = '<?= Url::to(['edit-ajax']) ?>';
        $('#qrSrc').attr('src', url + '?' + str);
    })

</script>
