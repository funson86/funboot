<?php

use common\helpers\ImageHelper;
use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\base\Attachment as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\IpHelper;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Attachments');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->module->id . '_' . $this->context->id] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::buttonModal(['/file/index'], Yii::t('app', 'File'), ['size' => 'Max', 'class' => 'btn btn-success']) ?>
                    <?= Html::export() ?>
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

                        'id',
                        ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', ArrayHelper::map($this->context->getStores(), 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'name', 'format' => 'raw', 'value' => function ($model) { return Html::field('name', $model->name); }, 'filter' => true,],
                        'driver',
                        ['attribute' => 'upload_type', 'value' => function ($model) { return ActiveModel::getUploadTypeLabels($model->upload_type); }, 'filter' => Html::activeDropDownList($searchModel, 'upload_type', ActiveModel::getUploadTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // 'file_type',
                        // 'path',
                        //'url:url',
                        [
                            'attribute' => 'url',
                            'filter' => false, // 不显示搜索框
                            'format' => 'raw',
                            'value' => function ($model) {
                                if (($model['upload_type'] == ActiveModel::UPLOAD_TYPE_IMAGE || preg_match("/^image/", $model['file_type'])) && $model['ext'] != 'psd') {
                                    return ImageHelper::fancyBox($model->url);
                                }
                                return Html::a('预览', $model->url, [
                                    'target' => '_blank'
                                ]);
                            },
                        ],
                        //'size',
                        [
                            'attribute' => 'size',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asShortSize($model->size, 0);
                            },
                        ],
                        'ext',
                        // 'year',
                        // 'month',
                        // 'day',
                        // 'width',
                        // 'height',
                        // 'ip',
                        [
                            'attribute' => 'ip',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return IpHelper::ip2Location($model->ip) . '<br/>' . $model->ip;
                            },
                        ],
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, 'filter' => Html::activeDropDownList($searchModel, 'type', ActiveModel::getTypeLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'sort', 'format' => 'raw', 'value' => function ($model) { return Html::sort($model->sort); }, 'filter' => false,],
                        ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        'created_at:datetime',
                        // 'updated_at:datetime',
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        Html::actionsModal(),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
