<?php
use yii\helpers\Html;

$this->title = Yii::t('mall', 'Payment has been cancelled');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row page-section">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card message-send-view">
            <div class="card-header text-center">
                <?= Html::encode($this->title) ?>
            </div>

            <div class="card-body">
                <p class="attention-icon"><i class="fa fa-close text-danger"></i></p>
                <div class="form-group">
                    <p><?= Yii::t('mall', 'Payment has been cancelled for some problem.') ?></p>
                </div>
                <div class="form-group text-center pt-3">
                    <?= Html::a(Yii::t('app', 'Go Home'), ['/'], ['class' => 'btn btn-secondary control-full']) ?>
                </div>

            </div>
        </div>
    </div>
</div>
