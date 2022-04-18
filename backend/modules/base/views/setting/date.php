<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;

?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->id . '_' . $row['id']] ?? null) ?> <?= Html::aVip($row['grade'] > 1 ? (Yii::$app->params['helpUrl'][Yii::$app->language]['vip_' . $row['grade']] ?? null) : '') ?>
    <?= kartik\date\DatePicker::widget([
        'name' => 'setting[' . $row['code'] . ']',
        'value' => $row['setting']['value'] ?? date('Y-m-d', strtotime('+2 days')),
        'language' => 'zh-CN',
        'layout'=>'{picker}{input}',
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true, // 今日高亮
            'autoclose' => true, // 选择后自动关闭
            'todayBtn' => true, // 今日按钮显示
        ],
        'options'=>[
            'class' => 'form-control no_bor',
        ]
    ]) ?>
</div>
