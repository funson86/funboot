<?php

use common\helpers\Html;
use common\models\base\Setting;
use yii\helpers\HtmlPurifier;

?>

<div class="form-group">
    <?= Html::label(Yii::t('setting', $row['name']), $row['code'], ['class' => 'control-label form-check-label']); ?>
    <small><?= HtmlPurifier::process(Yii::t('setting', $row['brief'])) ?></small>
    <div class="col-sm-push-10">
    <?= \common\components\uploader\FileWidget::widget([
        'name' => "setting[" . $row['code'] . "]",
        'value' => $row['setting']['value'] ?? $row['value_default'],
        'uploadType' => 'image',
        'theme' => 'default',
        'config' => [
            'pick' => [
                'multiple' => false,
            ],
        ]
    ]) ?>
    </div>
</div>