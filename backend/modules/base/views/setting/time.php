<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;

?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['description'])) ?></small>
    <?= \kartik\time\TimePicker::widget([
        'name' => 'setting[' . $row['code'] . ']',
        'value' => $row['setting']['value'] ?? $row['value_default'],
        'language' => 'zh-CN',
        'pluginOptions' => [
            'showSeconds' => true,
            'showMeridian' => false,
            'minuteStep' => 1,
            'secondStep' => 5,
        ],
    ]) ?>
</div>
