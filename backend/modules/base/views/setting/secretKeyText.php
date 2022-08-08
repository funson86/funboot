<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;

?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['id'] . ' ' . $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->id . '_' . $row['id']] ?? null) ?> <?= Html::aVip($row['grade'] > 1 ? (Yii::$app->params['helpUrl'][Yii::$app->language]['vip_' . $row['grade']] ?? null) : '') ?>
    <div class="input-group mb-3">
        <?= Html::textInput('setting[' . $row['code'] . ']', $row['setting']['value'] ?? $row['value_default'], ['class' => 'form-control', 'id' => $row['id']]); ?>
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" onclick="createKey(<?= $row['value_range'] ?>, <?= $row['id'] ?>)"><?= Yii::t('app', 'Create New') ?></button>
        </div>
    </div>
</div>
