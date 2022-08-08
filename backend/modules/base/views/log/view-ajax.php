<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Log as ActiveModel;
use common\helpers\StringHelper;
use yii\widgets\DetailView;

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

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover box'],
        'attributes' => [
            'id',
            ['attribute' => 'store_id', 'visible' => $this->context->isAdmin(), 'value' => function ($model) { return $model->store->name ?? '-'; }, ],
            ['attribute' => 'user_id', 'value' => function ($model) { return $model->user->username ?? '-'; }, ],
            'name',
            'url:url',
            ['attribute' => 'method', 'value' => function ($model) { return ActiveModel::getMethodLabels($model->method); }, ],
            'params:ntext',
            'user_agent',
            ['attribute' => 'agent_type', 'value' => function ($model) { return ActiveModel::getAgentTypeLabels($model->agent_type); }, ],
            'ip',
            'ip_info',
            'code',
            'msg',
            'data:json',
            'cost_time',
            ['attribute' => 'type', 'value' => function ($model) { return ActiveModel::getTypeLabels($model->type); }, ],
            'sort',
            ['attribute' => 'status', 'value' => function ($model) { return ActiveModel::getStatusLabels($model->status, true); }, ],
            'created_at:datetime',
            'updated_at:datetime',
            ['attribute' => 'created_by', 'value' => function ($model) { return $model->createdBy->nameAdmin ?? '-'; }, ],
            ['attribute' => 'updated_by', 'value' => function ($model) { return $model->updatedBy->nameAdmin ?? '-'; }, ],
        ],
    ]) ?>

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