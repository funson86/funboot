<?php
use common\models\mall\Address as ActiveModel;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  ActiveModel $model */
?>

<div class="info-box position-relative shadow-sm">
    <div class="info-box-content">
        <p class="info-box-text m-0"><?= $model->name ?> <?= $model->mobile ?> <?= $model->is_default ? '<span class="pull-right btn-xs btn-success">' . Yii::t('app', 'Default') . '</span>' : '' ?></p>
        <p class="info-box-text small m-0"><?= $model->address ?></p>
        <p class="info-box-text small m-0"><?= $model->address2 ?></p>
        <p class="info-box-text small m-0"><?= $model->postcode ?> <span class="pull-right"><?= $model->country ?></span></p>
        <span class="info-box-text text-right">
            <?= Html::a(Yii::t('app', 'Edit'), ['/mall/address/edit', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary px-3'], false) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['/mall/address/delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger ml-3'], false) ?>
        </span>
    </div>
</div>
