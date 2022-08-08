<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\enums\YesNo;
use <?= ltrim($generator->modelClass, '\\') ?> as ActiveModel;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="card-header">
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>, ['edit', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card-body">

        <?= "<?= " ?>DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-hover box'],
            'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "                '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (in_array($column->name, ['store_id'])) {
            echo "                ['attribute' => '" . $column->name . "', 'visible' => \$this->context->isAdmin(), 'value' => function (\$model) { return \$model->store->name ?? '-'; }, ],\n";
        } elseif (in_array($column->name, ['parent_id'])) {
            echo "                ['attribute' => '" . $column->name . "', 'value' => function (\$model) { return \$model->parent->name ?? '-'; }, ],\n";
        } elseif (in_array($column->name, ['user_id'])) {
            echo "                ['attribute' => '" . $column->name . "', 'value' => function (\$model) { return \$model->user->username ?? '-'; }, ],\n";
        } elseif (substr_compare($column->name, '_id', -strlen('_id')) === 0) {
            echo "                ['attribute' => '" . $column->name . "', 'value' => function (\$model) { return \$model->" . (Inflector::variablize(substr($column->name, 0, strlen($column->name) - 3))) . "->name ?? '-'; }, ],\n";
        } elseif (strpos($column->name, 'is_') === 0) {
            echo "                ['attribute' => '" . $column->name . "', 'value' => function (\$model) { return YesNo::getLabels(\$model->" . $column->name . "); }, ],\n";
        } elseif (in_array($column->name, ['type']) || (substr_compare($column->name, '_type', -strlen('_type')) === 0)) {
            echo "                ['attribute' => '" . $column->name . "', 'value' => function (\$model) { return ActiveModel::get" . Inflector::camelize($column->name) . "Labels(\$model->" . $column->name . "); }, ],\n";
        } elseif (in_array($column->name, ['status'])) {
            echo "                ['attribute' => '" . $column->name . "', 'value' => function (\$model) { return ActiveModel::get" . Inflector::camelize($column->name) . "Labels(\$model->" . $column->name . ", true); }, ],\n";
        } elseif (substr_compare($column->name, '_by', -strlen('_by')) === 0) {
            echo "                ['attribute' => '" . $column->name . "', 'value' => function (\$model) { return \$model->" . Inflector::variablize($column->name) . "->nameAdmin ?? '-'; }, ],\n";
        } elseif (isset($generator->inputType[$column->name]) && in_array($generator->inputType[$column->name], ['dropDownList', 'radioList'])) {
            echo "                ['attribute' => '" . $column->name . "', 'value' => function (\$model) { return ActiveModel::get" . Inflector::camelize($column->name) . "Labels(\$model->" . $column->name . "); }, ],\n";
        } else {
            echo "                '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
            ],
        ]) ?>

    </div>
</div>
