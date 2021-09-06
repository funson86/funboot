<?php
// use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use common\models\cms\Catalog;

$this->title = Yii::t('app', 'Choose Catalog');

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?= $this->title ?>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => "<div class='col-sm-2 text-sm-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
                        'options' => ['class' => 'form-group row'],
                    ],
                ]); ?>
                <div class="col-sm-12 p-0">
                    <?= $form->field($model, 'catalog_id')->dropDownList(Catalog::getTreeIdLabel(0, false)) ?>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 p-0 text-center">
                        <?= Html::submitButton(Yii::t('app', 'Next'), ['class' => 'btn btn-primary pl-3 pr-3']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

