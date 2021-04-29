<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use common\models\User as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body user-view">

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover box', 'style' => 'table-layout:fixed; width:100%;'],
        'attributes' => [
            'id',
            'store_id',
            'parent_id',
            'username',
            'auth_key',
            'token',
            'access_token',
            'password_hash',
            'password_reset_token',
            'verification_token',
            'email:email',
            'mobile',
            'auth_role',
            'name',
            'avatar',
            'brief',
            ['attribute' => 'sex', 'value' => function ($model) { return ActiveModel::getSexLabels($model->sex); }, ],
            'area',
            'province_id',
            'city_id',
            'district_id',
            'address',
            'birthday',
            'point',
            'balance',
            'remark',
            'last_login_at:datetime',
            'last_login_ip',
            'last_paid_at:datetime',
            'last_paid_ip',
            'consume_count',
            'consume_amount',
            'type',
            'sort',
            ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status); }, ],
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
