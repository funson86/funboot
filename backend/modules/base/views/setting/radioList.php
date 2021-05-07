<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;

$value = $row['setting']['value'] ?? '';
?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small>
    <div class="col-sm-push-10">
        <?php foreach ($valueRange as $key => $v) { ?>
            <label class="radio-inline">
                <input type="radio" name="setting[<?= $row['code'] ?>]" class="radio" value="<?= $key ?>" <?php if ($key == $value || (is_null($value) && $key == $valueDefault)) { echo 'checked'; } ?>>
                <?= Yii::t('setting', $v) ?>
            </label>
        <?php } ?>
    </div>
</div>
