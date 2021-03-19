<?php

use common\models\wechat\Tag;
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

$tag = Tag::find()->where(['store_id' => $this->context->getStoreId()])->one();
$tags = ArrayHelper::map($tag->tags, 'id', 'name');
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language]['Fans'] ?? null) ?></h2>
                <div class="card-tools">
                    <?php if (\common\helpers\AuthHelper::verify('/wechat/fan/edit-ajax-sync-select')) { ?>
                        <span class="btn btn-primary btn-xs" id="syncSelect"><i class="icon ion-ios-cloud-download-outline"></i> <?= Yii::t('app', 'Sync Select') ?></span>
                    <?php } ?>
                    <?php if (\common\helpers\AuthHelper::verify('/wechat/fan/edit-ajax-sync-all')) { ?>
                        <span class="btn btn-primary btn-xs" id="syncAll"><i class="icon ion-ios-cloud-download-outline"></i> <?= Yii::t('app', 'Sync All') ?></span>
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
                        ['attribute' => 'subscribe_scene', 'value' => function ($model) { return ActiveModel::getSubscribeSceneLabels($model->subscribe_scene); }, 'filter' => Html::activeDropDownList($searchModel, 'subscribe_scene', ActiveModel::getSubscribeSceneLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        ['attribute' => 'tagid_list', 'value' => function ($model) use ($tags) { return ActiveModel::getTagIdListLabels($model->tagid_list, $tags); }, 'filter' => false,],
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
                        ['attribute' => 'subscribe', 'format' => 'raw', 'value' => function ($model) { return Html::color($model->subscribe, YesNo::getLabels($model->subscribe), [], [YesNo::NO]); }, 'filter' => Html::activeDropDownList($searchModel, 'subscribe', YesNo::getLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'subscribe_time:datetime',

                        [
                            'header' => Yii::t('app', 'Actions'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {edit-tag} {edit-message}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::viewModal(['view-ajax', 'id' => $model->id]);
                                },
                                'edit-tag' => function ($url, $model, $key) {
                                    return Html::editModal(['edit-ajax-tag', 'id' => $model->id], Yii::t('app', 'Tag'), ['class' => 'btn btn-info']);
                                },
                                'edit-message' => function ($url, $model, $key) {
                                    return Html::editModal(['edit-ajax-message', 'id' => $model->id], Yii::t('app', 'Message'));
                                },
                            ],
                            'headerOptions' => ['class' => 'action-column'],
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php
$urlFanEditAjaxSyncSelect = Url::to(['edit-ajax-sync-select'], false, true);
$urlFanEditAjaxSyncAll = Url::to(['edit-ajax-sync-all'], false, true);

$js = <<<JS

function syncAll() {
    $.ajax({
        type: "get",
        url: "{$urlFanEditAjaxSyncAll}",
        dataType: "json",
        success: function (data) {
            if (parseInt(data.code) === 200) {
                fbInfo('同步成功')
                setTimeout(function () {
                    window.location.reload();
                }, 3000)
            }
        }
    });
}

$('#syncSelect').click(function() {
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
        url: "{$urlFanEditAjaxSyncSelect}",
        dataType: "json",
        data: {
            openids: openids
        },
        success: function (data) {
            if (parseInt(data.code) === 200) {
                fbInfo('同步成功')
                setTimeout(function () {
                    window.location.reload();
                }, 3000)
            }
        }
    });

});

$('#syncAll').click(function() {
    var openids = [];

    fbInfo('同步中，请不要关闭窗口');

    syncAll();
});

JS;

$this->registerJs($js);