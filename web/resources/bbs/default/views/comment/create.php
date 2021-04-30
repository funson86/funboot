<?php
?>

<div class="card">
    <div class="card-header">
        <?= Yii::t('app', 'Create ') . Yii::t('app', 'Comment') ?>
    </div>

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
