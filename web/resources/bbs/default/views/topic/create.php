<?php
$this->title = Yii::t('app', 'Publish');
?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <?= $this->title ?>
        </div>
        <div class="card-body p-0">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

