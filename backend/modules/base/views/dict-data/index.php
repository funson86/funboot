<?php

use common\models\base\Dict;
use yii\grid\GridView;
use common\helpers\Html;
use common\models\base\DictData as ActiveModel;
use common\helpers\Url;
use yii\helpers\Inflector;

$dicts = Dict::find()->all();
$dictId = Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Dict Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .dict-data .active {background: #00a2d4}
    .dict-data .active a, .dict-data .active a:hover {color: #FFF}
</style>

<div class="row">
    <div class="col-md-3">
        <?= Html::createModal(['edit-ajax-dict'], Yii::t('app', 'Create ') . Yii::t('app', 'Dict'), ['class' => 'btn btn-sm btn-primary mb-3']) ?>
        <a class="btn btn-sm btn-success mb-3 need-id" href="<?= Url::to(['edit-ajax-dict', 'id' => (Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0)]) ?>" data-link="<?= Url::to(['edit-ajax-dict']) ?>" data-toggle="modal" data-target="#ajaxModal" id="editDict"><?= Yii::t('app', 'Edit') ?></a>
        <a class="btn btn-sm btn-danger mb-3 need-id" href="<?= Url::to(['delete-dict', 'id' => (Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0)]) ?>" data-link="<?= Url::to(['delete-dict']) ?>" data-toggle="modal" data-target="#ajaxModal" id="deleteDict"><?= Yii::t('app', 'Delete') ?></a>

        <!--<div class="btn-group mb-3">
            <button type="button" class="btn btn-default">更多操作</button>
            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                <span class="sr-only">Toggle Dropdown</span>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="<?= Url::to(['edit-ajax-dict']) ?>" data-link="<?= Url::to(['edit-ajax-dict']) ?>" data-toggle="modal" data-target="#ajaxModal" id="editDict">编辑</a>
                    <?= Html::editModal(['edit-ajax-dict'], null, ['class' => 'dropdown-item']) ?>
                    <?= Html::delete(['delete-dict'], null, ['class' => 'dropdown-item']) ?>
                </div>
            </button>
        </div>-->
        <!--a href="compose.html" class="btn btn-default mb-3">更多操作</a-->
        <!--<?= Html::groupButton(['edit-ajax-dict' => Yii::t('app', 'Edit'), 'delete-dict' => Yii::t('app', 'Delete')], Yii::t('app', 'More'), ['class' => 'btn-group mb-3 ']) ?>-->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Yii::t('app', 'Dicts') ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column dict-data">
                    <?php foreach ($dicts as $dict) { ?>
                    <li class="nav-item <?= ($dict->id == $dictId) ? 'active' : '' ?>" data-id="<?= $dict->id ?>">
                        <a href="<?= Url::to(['index', 'ModelSearch' => ['dict_id' => $dict->id]]) ?>" class="nav-link">
                            <?= $dict->name ?> [<?= $dict->code ?>]
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.card-body -->
                            </div>
                </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->module->id . '_' . $this->context->id] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::filterModal() ?>
                    <?= isset(Yii::$app->request->get('ModelSearch')['dict_id']) ? (Html::createModal(['edit-ajax', 'dict_id' => (Yii::$app->request->get('ModelSearch')['dict_id'])], Yii::t('app', 'Create ') . Yii::t('app', 'Dict Data'), ['class' => 'btn btn-sm btn-primary need-id'])) : '' ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?//= $this->render('@backend/views/site/_select', ['model' => $searchModel, 'dataProvider' => $dataProvider]) ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'visible' => false,
                        ],

                        // 'id',
                        // ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name; }, 'filter' => Html::activeDropDownList($searchModel, 'store_id', $this->context->getStoresIdName(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],,
                        // 'dict_id',
                        'name',
                        'code',
                        'value',
                        'brief',
                        // ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, ],
                        'sort',
                        // ['attribute' => 'status', 'format' => 'raw', 'value' => function ($model) { return ActiveModel::isStatusActiveInactive($model->status) ? Html::status($model->status) : ActiveModel::getStatusLabels($model->status, true); }, 'filter' => Html::activeDropDownList($searchModel, 'status', ActiveModel::getStatusLabels(null, true), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),],
                        // ['attribute' => 'created_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'updated_at', 'format' => 'datetime', 'filter' => false],
                        // ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
                        // ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],

                        Html::actionsModal(),
                    ]
                ]); ?>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

<?= $this->render('@backend/views/site/_filter', ['model' => $searchModel, 'dataProvider' => $dataProvider]) ?>

<script>
    var currentDictId = <?= Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0 ?>;
    $('.need-id').click(function () {
        if (currentDictId == 0) {
            fbError(fbT('Pleas select dict first'))
            return false;
        }
        return true;
    })

    $('.nav-item').click(function () {
        currentDictId = $(this).data('id');
        $('.nav-item').removeClass('active');
        $(this).addClass('active');

        let link = $('#editDict').data('link') + '?id=' + currentDictId;
        $('#editDict').attr('href', link)

        link = $('#deleteDict').data('link') + '?id=' + currentDictId;
        $('#deleteDict').attr('href', link)
    })
</script>
