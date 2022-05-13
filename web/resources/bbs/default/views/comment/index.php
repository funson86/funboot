<?php

?>
<div class="card">
    <div class="card-header">
        <?= Yii::t('app', 'Received {0} reply', $topic->like) ?>
    </div>

    <div class="card-body p-0">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'list-group-item media mt0'],
            'summary' => false,
            'itemView' => $this->context->action->id . '_',
        ]) ?>
    </div>

</div>
