<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use <?= ltrim($generator->modelClass, '\\') ?> as ActiveModel;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= "<?php " ?>$form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= "<?" ?>= $this->title ?></h2></div>
            <div class="card-body">
                <div class="col-sm-12">
<?php
if (!empty($generator->formFields)) {
    foreach ($generator->formFields as $attribute) {
        echo "                    <?= " . $generator->generateActiveFieldFunboot($attribute) . " ?>\n";
    }
} else {
    foreach ($generator->getColumnNames() as $attribute) {
        if (in_array($attribute, ['id', 'created_at', 'updated_at', 'created_by', 'updated_by'])) {
            continue;
        }
        if (in_array($attribute, $safeAttributes)) {
            echo "                    <?= " . $generator->generateActiveFieldFunboot($attribute) . " ?>\n";
        }
    }
}?>
                </div>
            </div>
            <div class="card-footer">
                <?= "<?" ?>= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                <span class="btn btn-default" onclick="history.go(-1)"><?= "<?" ?>= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?= "<?php " ?>ActiveForm::end(); ?>
