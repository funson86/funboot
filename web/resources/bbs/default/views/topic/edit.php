<?php
// use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use common\models\bbs\Node;
use common\models\bbs\Topic as ActiveModel;

$this->title = Yii::t('app', 'Publish') . $model->node->name;

$changeFormat = (Yii::$app->request->get('format', ActiveModel::FORMAT_HTML) == ActiveModel::FORMAT_HTML) ? ActiveModel::FORMAT_MARKDOWN : ActiveModel::FORMAT_HTML;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= $this->title ?></h2>
                <div class="card-tools">
                    <?= Html::a(Yii::t('app', 'Choose Node'), ['/bbs/topic/edit-node'], ['class' => 'btn btn-sm btn-success']) ?>
                    <?= Html::a(ActiveModel::getFormatLabels($changeFormat), ['/bbs/topic/edit', 'node_id' => Yii::$app->request->get('node_id'), 'format' => $changeFormat], ['class' => 'btn btn-sm btn-info']) ?>
                </div>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'options' => ['class' => 'form-group row'],
                    ],
                ]); ?>
                <div class="col-sm-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'tag_id')->dropdownList(\common\models\bbs\Tag::getIdLabel(true))->label(Yii::t('app', 'Cities')) ?>
                    <?php foreach ($metas as $meta) { ?>
                        <div class="form-group row field-topic-node_id">
                            <label class="control-label" for="topic-node_id"><?= $meta->name ?></label>
                            <?= Html::textInput("Meta[$meta->id]", $mapMetaIdContent[$meta->id] ?? '', ['class' => 'form-control']) ?>
                        </div>
                    <?php } ?>
                    <?php if ($model->format == ActiveModel::FORMAT_MARKDOWN || Yii::$app->request->get('format', ActiveModel::FORMAT_HTML) == ActiveModel::FORMAT_MARKDOWN) { ?>
                        <?= $form->field($model, 'content')->widget(\common\widgets\markdown\Markdown::class, []) ?>
                    <?php } else { ?>
                    <?= $form->field($model, 'content', ['options' => ['style' => 'display: block'], 'labelOptions' => ['class' => 'control-label control-label-full']])->widget(\common\components\ueditor\Ueditor::class, ['style' => 2]) ?>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 p-0 text-center">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary pl-3 pr-3']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('body').addClass('pt-0');
        $('nav').removeClass('fixed-top');
    });
</script>
