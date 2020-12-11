<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use common\helpers\Html;
use common\components\enums\YesNo;
use <?= ltrim($generator->modelClass, '\\') ?> as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= "<?= " ?>!is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= "<?= " ?>Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language]['<?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>'] ?? null) ?></h2>
                <div class="card-tools">
                    <?= "<?= " ?>Html::createModal() ?>
                    <?= "<?= " ?>Html::export() ?>
                    <?= "<?= " ?>Html::import() ?>
                </div>
            </div>
            <div class="card-body">
<?php if ($generator->indexWidgetType === 'grid'): ?>
                <?= "<?= " ?>GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover'],
                    <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false,
                        ],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "                        '" . $name . "',\n";
        } else {
            echo "                        //'" . $name . "',\n";
        }
    }
} else {
    $listFields = !empty($generator->listFields) ? $generator->listFields : [];
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        $comment = !in_array($column->name, $listFields) ? '// ' : '';
        // 如果是下拉或者单选
        if ($column->name == 'status') {
            $filter = "'filter' => Html::activeDropDownList(\$searchModel, '" . $column->name . "', ActiveModel::get" . Inflector::camelize($column->name) . "Labels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),";
            echo "                        " . $comment . "['attribute' => '" . $column->name . "', 'format' => 'raw', 'value' => function (\$model) { return Html::status(\$model->status); }, " . $filter . "],\n";
        } elseif ($column->name == 'store_id') {
            $filter = "'filter' => Html::activeDropDownList(\$searchModel, 'store_id', ArrayHelper::map(\$this->context->getStores(), 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),";
            echo "                        " . $comment . "['attribute' => '" . $column->name . "', 'visible' => \$this->context->isAdmin(), 'value' => function (\$model) { return \$model->store->name; }, " . $filter . "],\n";
        } elseif ($column->name == 'sort') {
            $filter = "'filter' => false,";
            echo "                        " . $comment . "['attribute' => '" . $column->name . "', 'format' => 'raw', 'value' => function (\$model) { return Html::sort(\$model->sort); }, " . $filter . "],\n";
        } elseif ($column->name == 'name') {
            $filter = "'filter' => true,";
            echo "                        " . $comment . "['attribute' => '" . $column->name . "', 'format' => 'raw', 'value' => function (\$model) { return Html::field('" . $column->name . "', \$model->name); }, " . $filter . "],\n";
        } elseif (isset($generator->inputType[$column->name]) && in_array($generator->inputType[$column->name], ['dropDownList'])) {
            $filter = "'filter' => Html::activeDropDownList(\$searchModel, '" . $column->name . "', ActiveModel::get" . Inflector::camelize($column->name) . "Labels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),";
            echo "                        " . $comment . "['attribute' => '" . $column->name . "', 'value' => function (\$model) { return ActiveModel::get" . Inflector::camelize($column->name) . "Labels(\$model->" . $column->name . "); }, " . $filter . "],\n";
        } elseif (isset($generator->inputType[$column->name]) && in_array($generator->inputType[$column->name], ['radioList'])) {
            $filter = "'filter' => Html::activeDropDownList(\$searchModel, '" . $column->name . "', YesNo::getLabels(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]),";
            echo "                        " . $comment . "['attribute' => '" . $column->name . "', 'value' => function (\$model) { return YesNo::getLabels(\$model->" . $column->name . "); }, " . $filter . "],\n";
        } else {
            echo "                        " . $comment . "'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

                        Html::actionsModal(),
                    ]
                ]); ?>
<?php else: ?>
                <?= "<?= " ?>ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                    },
                ]) ?>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>
