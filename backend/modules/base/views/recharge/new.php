<?php

use common\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Recharge as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\Recharge */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Recharge');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recharges'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$currency = $this->context->store->settings['payment_currency'] ?? '$';
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins text-warning"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app', 'Fund') ?></span>
                <span class="info-box-number">
                    <?= $currency ?> <?= $this->context->store->fund ?? 0 ?>
                    <!--small>%</small-->
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>

        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <div class="col-sm-12">
                    <?= $form->field($model, 'amount', ['inputTemplate' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">' . $currency . '</span></div>{input}</div>',])->label(false) ?>
                    <?= $form->field($model, 'message')->textarea(['rows' => 4]) ?>

                    <?php if ($model->scenario == 'captchaRequired') { ?>
                        <?= $form->field($model,'verifyCode')->widget(\yii\captcha\Captcha::class, [
                            'template' => '<div class="row mx-1"><div class="col-xs-7">{input}</div><div class="col-xs-5">{image}</div></div>',
                            'imageOptions' => [
                                'alt' => Yii::t('app', 'Click to change'),
                                'title' => Yii::t('app', 'Click to change'),
                                'style' => 'cursor:pointer'
                            ],
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => Yii::t('app', 'Verification Code'),
                            ],
                        ])->label(false); ?>
                    <?php } ?>

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