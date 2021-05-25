<?php
// use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use common\models\bbs\Node;
use common\models\bbs\Topic as ActiveModel;

$this->title = Yii::t('app', 'Grab');

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
                        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
                        'options' => ['class' => 'form-group row'],
                    ],
                ]); ?>
                <div class="col-sm-12 p-0">
                    <?= $form->field($model, 'name')->dropDownList(ActiveModel::getSourceLabels())->label(Yii::t('app', 'Source')) ?>
                    <?= $form->field($model, 'redirect_url')->textInput()->label(Yii::t('app', 'Url')) ?>
                    <?= $form->field($model, 'node_id')->dropDownList(Node::getTreeIdLabel(0, false)) ?>
                    <?= $form->field($model, 'tag_id')->dropdownList(\common\models\bbs\Tag::getIdLabel(true))->label(Yii::t('app', 'Cities')) ?>
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

