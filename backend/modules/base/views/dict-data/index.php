<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\models\base\DictData as ActiveModel;
use common\helpers\Url;
use yii\helpers\Inflector;

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
        <?= Html::createModal(['edit-ajax-dict'], '添加数据字典', ['class' => 'btn btn-sm btn-primary mb-3']) ?>
        <a class="btn btn-sm btn-success mb-3 need-id" href="<?= Url::to(['edit-ajax-dict', 'id' => (Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0)]) ?>" data-link="<?= Url::to(['edit-ajax-dict']) ?>" data-toggle="modal" data-target="#ajaxModal" id="editDict">编辑</a>
        <a class="btn btn-sm btn-danger mb-3 need-id" href="<?= Url::to(['delete-dict', 'id' => (Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0)]) ?>" data-link="<?= Url::to(['delete-dict']) ?>" data-toggle="modal" data-target="#ajaxModal" id="deleteDict">删除</a>

        <!--<div class="btn-group mb-3">
            <button type="button" class="btn btn-default">更多操作</button>
            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                <span class="sr-only">Toggle Dropdown</span>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="<?= Url::to(['edit-ajax-dict']) ?>" data-link="<?= Url::to(['edit-ajax-dict']) ?>" data-toggle="modal" data-target="#ajaxModal" id="editDict">编辑</a>
                    <?= Html::editModal(['edit-ajax-dict'], '编辑', ['class' => 'dropdown-item']) ?>
                    <?= Html::editModal(['delete-dict'], '删除', ['class' => 'dropdown-item']) ?>
                </div>
            </button>
        </div>-->
        <!--a href="compose.html" class="btn btn-default mb-3">更多操作</a-->
        <!--<?= Html::groupButton(['edit-ajax-dict' => '编辑', 'delete-dict' => '删除'], '更多操作', ['class' => 'btn-group mb-3 ']) ?>-->

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
                    <li class="nav-item <?php if ($dict->id == $dictId) echo 'active' ?>" data-id="<?= $dict->id ?>">
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
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?></h2>
                <div class="card-tools">
                    <?= Html::createModal(['edit-ajax', 'dict_id' => (Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0)], '添加字典项', ['class' => 'btn btn-sm btn-primary need-id']) ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div>
            </div>
            <!-- /.card-header -->
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

                        //'id',
                        //'store_id',
                        //'dict_id',
                        'name',
                        'code',
                        'value',
                        'description',
                        //'type',
                        'sort',
                        //'status',
                        //'created_at',
                        //'updated_at',
                        //'created_by',
                        //'updated_by',

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

<script>
    var currentDictId = <?= Yii::$app->request->get('ModelSearch')['dict_id'] ?? 0 ?>;
    $('.need-id').click(function () {
        if (currentDictId == 0) {
            fbError('请先选择字典项')
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
