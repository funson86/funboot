<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\bbs\Node as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\bbs\Node */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Node');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <div class="col-sm-12">
                    <?= $form->field($model, 'parent_id')->dropDownList(ActiveModel::getParentIdLabels()) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'is_nav')->radioList(YesNo::getLabels()) ?>
                    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'redirect_url')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'page_size')->textInput() ?>
                    <?= $form->field($model, 'template')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'template_topic')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                </div>
            </div>
            <div class="card-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                <span class="btn btn-default" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
