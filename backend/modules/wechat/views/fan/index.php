<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\wechat\Fan as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Fans');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language]['Fans'] ?? null) ?></h2>
                <div class="card-tools">
                    <?php if (\common\helpers\AuthHelper::verify('/wechat/fan/edit-ajax-refresh-select')) { ?>
                        <span class="btn btn-primary btn-xs" id="refreshSelect"><i class="icon ion-ios-cloud-download-outline"></i> Sync</span>
                    <?php } ?>
                    <?php if (\common\helpers\AuthHelper::verify('/wechat/fan/edit-ajax-refresh-all')) { ?>
                        <span class="btn btn-primary btn-xs" id="refreshAll"><i class="icon ion-ios-cloud-download-outline"></i> Sync All</span>
                    <?php } ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div>
            </div>
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false,
                        ],

                        [
                            'class'=>\yii\grid\CheckboxColumn::className(),
                            'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['key' => $model->openid, 'value' => $model->openid, 'class' => 'checkbox'];
                            }
                        ],
                        // 'id',
                        // ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', ArrayHelper::map($this->context->getStores(), 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        // 'description',
                        // 'unionid',
                        // 'openid',
                        'nickname',
                        [
                            'attribute' => 'headimgurl',
                            'filter' => false, // 不显示搜索框
                            'format' => 'raw',
                            'value' => function ($model) {
                                return \common\helpers\ImageHelper::fancyBox($model->headimgurl);
                            },
                        ],
                        ['attribute' => 'sex', 'value' => function ($model) { return ActiveModel::getSexLabels($model->sex); }, 'filter' => Html::activeDropDownList($searchModel, 'sex', ActiveModel::getSexLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'groupid',
                        ['attribute' => 'subscribe', 'value' => function ($model) { return YesNo::getLabels($model->subscribe); }, 'filter' => Html::activeDropDownList($searchModel, 'subscribe', YesNo::getLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'subscribe_time:datetime',
                        ['attribute' => 'subscribe_scene', 'value' => function ($model) { return ActiveModel::getSubscribeSceneLabels($model->subscribe_scene); }, 'filter' => Html::activeDropDownList($searchModel, 'subscribe_scene', ActiveModel::getSubscribeSceneLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'tagid_list:json',
                        // 'remark',
                        // 'country',
                        // 'province',
                        // 'city',
                        // 'language',
                        // 'qr_scene',
                        'qr_scene_str',
                        // 'last_longitude',
                        // 'last_latitude',
                        // 'last_address',
                        'last_updated_at:datetime',
                        // 'type',
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        // ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return Html::status($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'created_at:datetime',
                        // 'updated_at:datetime',
                        // 'created_by',
                        // 'updated_by',

                        Html::actionsModal(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php
$urlFanEditAjaxRefreshSelect = Url::to(['edit-ajax-refresh-select'], false, true);
$urlFanEditAjaxRefreshAll = Url::to(['edit-ajax-refresh-all'], false, true);

$js = <<<JS

function refreshAll() {
    $.ajax({
        type: "get",
        url: "{$urlFanEditAjaxRefreshAll}",
        dataType: "json",
        success: function (data) {
            if (parseInt(data.code) === 200) {
                fbInfo('同步成功')
            }
        }
    });
}

$('#refreshSelect').click(function() {
    var openids = [];
    
    fbInfo('同步中，请不要关闭窗口');

    $("#w0 :checkbox").each(function () {
        if(this.checked){
            var openid = $(this).val();
            openids.push(openid);
        }
    });

    $.ajax({
        type: "post",
        url: "{$urlFanEditAjaxRefreshSelect}",
        dataType: "json",
        data: {
            openids: openids
        },
        success: function (data) {
            if (parseInt(data.code) === 200) {
                fbInfo('同步成功')
            }
        }
    });

});

$('#refreshAll').click(function() {
    var openids = [];

    fbInfo('同步中，请不要关闭窗口');

    refreshAll();
});

JS;

$this->registerJs($js);