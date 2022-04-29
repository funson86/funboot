<?php

use common\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\widgets\multipleinput\MultipleInput;
use yii\helpers\Json;

$value = isset($row['setting']['value']) ? Json::decode($row['setting']['value']) : [];

$columns = [];
foreach ($valueRange as $k => $v) {
    array_push($columns, [
        'name' => $k,
        'title' => $v,
        'enableError' => false,
        'options' => [
            'class' => 'input-priority'
        ]
    ]);
}
?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['id'] . ' ' . $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->id . '_' . $row['id']] ?? null) ?> <?= Html::aVip($row['grade'] > 1 ? (Yii::$app->params['helpUrl'][Yii::$app->language]['vip_' . $row['grade']] ?? null) : '') ?>
    <div class="col-sm-push-10">
        <?= MultipleInput::widget([
            'max' => 100,
            'name' => 'setting[' . $row['code'] . ']',
            'value' => $value,
            'columns' => $columns,
            'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME
        ]) ?>
    </div>
</div>
