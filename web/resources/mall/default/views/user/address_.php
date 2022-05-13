<?php
use common\models\mall\Address as ActiveModel;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  ActiveModel $model */
?>

<div class="info-box position-relative shadow-sm">
    <div class="info-box-content">
        <p class="info-box-text m-0"><?= $model->first_name ?> <?= $model->last_name ?> <?= $model->mobile ?> <?= $model->is_default ? '<span class="pull-right btn-xs btn-success">' . Yii::t('app', 'Default') . '</span>' : '' ?></p>
        <p class="info-box-text small m-0"><?= $model->address ?> <?= $model->address2 ?> <?= $model->city ?> <?= $model->province ?> <?= $model->country ?> <?= $model->postcode ?></p>
        <span class="info-box-text text-right">
            <?= Html::a(Yii::t('app', 'Edit'), ['/mall/address/edit', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary px-3']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['/mall/address/delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger ml-3']) ?>
        </span>
    </div>
</div>
