<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\base\Recharge as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\base\Recharge */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recharges'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body recharge-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            'store_id',
            'user_id',
            'name',
            'sn',
            'mobile',
            'email:email',
            'remark',
            'payment_method',
            'payment_status',
            'paid_at:datetime',
            'amount',
            'tax',
            'invoice',
            'type',
            'sort',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
