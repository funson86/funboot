<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Log as ActiveModel;


/* @var $this yii\web\View */
/* @var $model common\models\base\Log */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="modal-header">
    <h4 class="modal-title"><?= $model->name ?? Yii::t('app', 'Basic info') ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <?= \common\widgets\echarts\Echarts::widget([
        'config' => ['server' => Url::to(['view-ajax-stat-login']), 'height' => '400px', 'defaultType' => 'yesterday'],
        'chartConfig' => ['today', 'yesterday', 'thisWeek', 'thisMonth', 'lastMonth', 'thisYear'],
    ]) ?>
</div>
