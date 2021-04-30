<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'action' => $model->isNewRecord ? ['/bbs/comment/create'] : ['/bbs/comment/update', 'id' => Yii::$app->request->getQueryParam('id')],
    'fieldConfig' => [
        'template' => "<div class='col-sm-12'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="col-sm-12 p-0">
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'topic_id')->hiddenInput() ?>
</div>
<div class="form-group">
    <div class="col-sm-12 p-0 text-left">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
