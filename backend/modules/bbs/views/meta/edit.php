<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\bbs\Meta as ActiveModel;

/* @var $this yii\web\View */
/* @var $model common\models\bbs\Meta */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id ? Yii::t('app', 'Edit ') : Yii::t('app', 'Create ')) . Yii::t('app', 'Meta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'form-group row'],
    ],
]); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="card">
            <div class="card-header"><h2 class="card-title"><?= $this->title ?></h2></div>
            <div class="card-body">
                <div class="col-sm-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'status')->radioList(ActiveModel::getStatusLabels()) ?>
                    <table class="table table-hover">
                        <thead>
                        <tr class="row">
                            <th class="col-3"><?= Yii::t('app', 'Name') ?></th>
                            <th class="col-5"><?= Yii::t('app', 'Brief') ?></th>
                            <th class="col-2"><?= Yii::t('app', 'Sort') ?></th>
                            <th class="col-2"><?= Yii::t('app', 'Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->children as $item) { ?>
                            <tr id="<?= $item->id ?>" class="row">
                                <td class="col-3">
                                    <?= Html::textInput('Sub[name][]', $item->name, [
                                        'class' => 'form-control name',
                                    ]) ?>
                                </td>
                                <td class="col-5">
                                    <?= Html::textInput('Sub[brief][]', $item->name, [
                                        'class' => 'form-control brief',
                                    ]) ?>
                                </td>
                                <td class="col-2">
                                    <?= Html::textInput('Sub[sort][]', $item->sort, [
                                        'class' => 'form-control sort',
                                    ]) ?>
                                </td>
                                <td class="col-2">
                                    <a href="javascript:void(0);" class="delete update"> <i class="icon ion-android-cancel"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr id="operation">
                            <td colspan="2"><a href="javascript:" id="add"><i class="icon ion-android-add-circle"></i> <?= Yii::t('app', 'Add Child') ?> </a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <?= Html::button(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'onclick' => 'beforeSubmit()']) ?>
                <span class="btn btn-white" onclick="history.go(-1)"><?= Yii::t('app', 'Back') ?></span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script id="addHtml" type="text/html">
    <tr class="row">
        <td class="col-3">
            <?= Html::textInput('Sub[name][]', '', [
                'class' => 'form-control name',
            ]) ?>
        </td>
        <td class="col-5">
            <?= Html::textInput('Sub[brief][]', '', [
                'class' => 'form-control brief',
            ]) ?>
        </td>
        <td class="col-2">
            <?= Html::textInput('Sub[sort][]', '50', [
                'class' => 'form-control sort',
            ]) ?>
        </td>
        <td class="col-2">
            <?= Html::hiddenInput('Sub[id][]', '') ?>
            <a href="javascript:void(0);" class="delete"> <i class="icon ion-android-cancel"></i></a>
        </td>
    </tr>
</script>

<script>
    // 增加
    $('#add').click(function () {
        let html = template('addHtml', []);
        $('#operation').before(html);
    });

    // 删除
    $(document).on("click", ".delete", function () {
        $(this).parent().parent().remove()
    });

    function beforeSubmit() {
        var submit = true;
        $('.name').each(function () {
            if (!$(this).val()) {
                fbWarning('<?= Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => Yii::t('app', 'Name')]) ?>');
                submit = false;
            }
        })

        $('.sort').each(function () {
            if (!$(this).val()) {
                fbWarning('<?= Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => Yii::t('app', 'Sort')]) ?>');
                submit = false;
            }

            if (isNaN($(this).val())) {
                fbWarning('<?= Yii::t('yii', '{attribute} must be a number.', ['attribute' => Yii::t('app', 'Sort')]) ?>');
                submit = false;
            }
        })

        if (submit) {
            $('#w0').submit();
        }
    }
</script>

