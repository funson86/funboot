<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;

?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small>
    <?= Html::textarea('setting[' . $row['code'] . ']', $row['setting']['value'] ?? $row['value_default'], ['class' => 'form-control', 'rows' => "4"]); ?>
</div>
