<?php
?>

<div class="card">
    <div class="card-header"><h6 class="card-title"><?= Yii::t('app', 'Update ') . Yii::t('app', 'Comment') ?></h6></div>

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
