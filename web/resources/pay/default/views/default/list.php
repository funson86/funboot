<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\pay\Payment as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;
use common\helpers\Url;
use common\models\pay\Payment;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Donation List');
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->request->get('status', Payment::STATUS_ACTIVE);
$statusLabel = ActiveModel::getStatusLabels($status);
?>
<style>
    .nav-tabs .active {
        border-top: 3px solid #007bff !important;
    }
    .grid-view .summary {
        padding: 0 0 0.5rem 0.5rem;
    }
    td .btn-xs {
        padding: 0.2rem;
        border-radius: .2rem;
        font-size: .9rem;
    }
</style>
<div class="content-wrapper">
    <div class="row content-row pb-5 pt-5">
        <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12">
            <div class="card">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link <?= $status == Payment::STATUS_ACTIVE ? 'active' : '' ?>" href="<?= Url::to(['list', 'status' => Payment::STATUS_ACTIVE], false, false) ?>">捐赠名单</a></li>
                        <li class="nav-item"><a class="nav-link <?= $status == Payment::STATUS_EXPIRED ? 'active' : '' ?>" href="<?= Url::to(['list', 'status' => Payment::STATUS_EXPIRED], false, false) ?>">忘了支付的</a></li>
                        <li class="nav-item"><a class="nav-link <?= $status == Payment::STATUS_INACTIVE ? 'active' : '' ?>" href="<?= Url::to(['list', 'status' => Payment::STATUS_INACTIVE], false, false) ?>">等待系统审核</a></li>
                    </ul>
                </div>
                <div class="card-body px-0">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ['class' => 'table table-hover'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'visible' => false,
                            ],

                            'name',
                            'bank_code',
                            'money',
                            'remark',
                            ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return Html::color($model->status, Payment::getStatusLabels($model->status), [Payment::STATUS_PAID], [Payment::STATUS_EXPIRED], [Payment::STATUS_INACTIVE]); }, ],
                            ['attribute' => 'created_at', 'format' => 'raw', 'value' => function ($model) { return date('Y-m-d H:i', $model->created_at); }, 'filter' => false, ],
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
