<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;
use common\helpers\ArrayHelper;

$value = ArrayHelper::intToArray(($row['setting']['value'] ?? intval($valueDefault)), $valueRange);
?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['id'] . ' ' . $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->id . '_' . $row['id']] ?? null) ?> <?= Html::aVip($row['grade'] > 1 ? (Yii::$app->params['helpUrl'][Yii::$app->language]['vip_' . $row['grade']] ?? null) : '') ?>
    <div class="col-sm-push-10">
        <?php foreach ($valueRange as $key => $v) { ?>
            <label class="radio-inline">
                <input type="checkbox" name="setting[<?= $row['code'] ?>]" class="checkbox" value="<?= $key ?>" <?= in_array(intval($key), $value) ? 'checked' : '' ?>>
                <?= Yii::t('setting', $v) ?>
            </label>
        <?php } ?>
    </div>
</div>
