<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;

?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->id . '_' . $row['id']] ?? null) ?> <?= Html::aVip($row['grade'] > 1 ? (Yii::$app->params['helpUrl'][Yii::$app->language]['vip_' . $row['grade']] ?? null) : '') ?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->id . '_' . $row['id']] ?? null) ?> <?= Html::aVip($row['grade'] > 1 ? (Yii::$app->params['helpUrl'][Yii::$app->language]['vip_' . $row['grade']] ?? null) : '') ?>
    <?= Html::textInput('setting[' . $row['code'] . ']', $row['setting']['value'] ?? $row['value_default'], ['class' => 'form-control']); ?>
</div>
