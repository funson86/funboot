<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;

?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['id'] . ' ' . $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->id . '_' . $row['id']] ?? null) ?> <?= Html::aVip($row['grade'] > 1 ? (Yii::$app->params['helpUrl'][Yii::$app->language]['vip_' . $row['grade']] ?? null) : '') ?>
    <div class="col-sm-push-10">
    <?= \common\components\uploader\FileWidget::widget([
        'name' => "setting[" . $row['code'] . "]",
        'value' => isset($row['setting']['value']) ? Json::decode($row['setting']['value']) : $row['value_default'],
        'uploadType' => 'image',
        'theme' => 'default',
        'config' => [
            'pick' => [
                'multiple' => true,
            ],
        ]
    ]) ?>
    </div>
</div>
