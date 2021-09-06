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
                <div class="card-title"><?= $this->title ?></div>
                <div class="card-tools">
                    <?= Html::a(Yii::t('app', 'Choose Node'), ['/bbs/topic/edit-node'], ['class' => 'btn btn-sm btn-success mr-2']) ?>
                    <?php
                        foreach (ActiveModel::getFormatLabels() as $code => $label) {
                            echo Html::a($label, ['/bbs/topic/edit', 'id' => Yii::$app->request->get('id'), 'node_id' => Yii::$app->request->get('node_id'), 'format' => $code], ['class' => 'btn btn-sm btn-info mr-2']);
                        }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'options' => ['class' => 'form-group row'],
                    ],
                ]); ?>
                <div class="col-sm-12">
                    <?php if (Yii::$app->request->get('id')) { ?>
                        <?= $form->field($model, 'node_id')->dropDownList(Node::getTreeIdLabel(0, false)) ?>
                    <?php } ?>
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
                    <?php } elseif ($model->format == ActiveModel::FORMAT_TEXTAREA || Yii::$app->request->get('format', ActiveModel::FORMAT_HTML) == ActiveModel::FORMAT_TEXTAREA) { ?>
                    <?= $form->field($model, 'content')->textarea(['rows' => 16]) ?>
                    <?php } else { ?>
                    <?= $form->field($model, 'content', ['options' => ['style' => 'display: block'], 'labelOptions' => ['class' => 'control-label control-label-full']])->widget(\common\components\ueditor\Ueditor::class, ['style' => 2]) ?>
                    <?php } ?>
                    <?= $this->context->isManager() ? $form->field($model, 'status', ['options' => ['style' => 'display: block'], 'labelOptions' => ['class' => 'control-label control-label-full']])->radioList(ActiveModel::getStatusLabels()) : '' ?>
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
