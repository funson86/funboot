<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Log as ActiveModel;
use common\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model common\models\base\Log */
/* @var $form yii\widgets\ActiveForm */


$dataOld = $dataNew = '{}';
$data = $model->data;
if ($model->type == ActiveModel::TYPE_ERROR) {
    $data = json_decode($model->data, true);
    $traces = [];
    if (isset($data['trace'])) {
        $data['trace'] = explode('#', $data['trace']);
        if (isset($data['trace'][0])) {
            unset($data['trace'][0]);
        }
    }
} elseif ($model->code == ActiveModel::CODE_UPDATE) {
    $strObj = json_decode($model->data);
    $dataOld = json_encode($strObj->old);
    $dataNew = json_encode($strObj->new);
} elseif (in_array($model->code, [ActiveModel::CODE_INSERT, ActiveModel::CODE_DELETE, ActiveModel::CODE_LOGIN_FAILED])) {
    $dataNew = $model->data;
}

?>

    <style>
        pre {outline: 1px solid #ccc; }
    </style>

    <div class="modal-header">
        <h4 class="modal-title"><?= $model->name ?: Yii::t('app', 'Basic info') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">

        <div class="row">
            <?php if ($model->code == ActiveModel::CODE_UPDATE) { ?>
            <div class="col-md-6">
                <p>修改之前</p>
                <pre id="jsonOld"></pre>
            </div>
            <div class="col-md-6">
                <p>修改之后</p>
                <pre id="jsonNew"></pre>
            </div>
            <?php } elseif (in_array($model->code, [ActiveModel::CODE_INSERT, ActiveModel::CODE_DELETE, ActiveModel::CODE_LOGIN_FAILED])) { ?>
                <div class="col-md-12">
                    <p>修改之前</p>
                    <pre id="jsonOld" class="hidden"></pre>
                    <pre id="jsonNew"></pre>
                </div>
            <?php } elseif ($model->type == ActiveModel::TYPE_ERROR) { ?>
            <div class="col-md-12">
                <pre id="jsonOld" class="hidden"></pre>
                <pre id="jsonNew" class="hidden"></pre>
                <pre id="jsonData"><?= json_encode($data, JSON_PRETTY_PRINT) ?></pre>
            </div>
            <?php } else { ?>
            <div class="col-md-12">
                <pre><?= StringHelper::unicodeDecode($model->data) ?></pre>
            <?php } ?>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
    </div>

<?php

$js = <<<JS
$('#jsonNew').text(JSON.stringify(JSON.parse('{$dataNew}'), null, 4))
$('#jsonOld').text(JSON.stringify(JSON.parse('{$dataOld}'), null, 4))
// $('#jsonData').text(JSON.stringify(JSON.parse($('#jsonData').html()), null, 4))
JS;
$this->registerJs($js);