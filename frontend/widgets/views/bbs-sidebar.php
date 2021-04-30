<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if ($type == 'topic') { ?>
<div class="card">
    <div class="card-body text-center">
        <?= Html::a(Html::tag('i', '', ['class' => 'bi-pencil']) . ' ' . Yii::t('app', 'Publish'), ['/bbs/topic/edit', 'type' => $type, 'from_id' => Yii::$app->request->get('id')], ['class' => 'btn btn-block btn-primary']) ?>
    </div>
</div>
<?php } ?>

<div class="card bbs-sidebar">
    <div class="card-header">
        <?= Yii::t('app', 'Hottest') ?>
    </div>
    <div class="card-body">
        <ul class="list">
            <li>Some quick example text to build on the card title and make up the bulk of the card's content.</li>
        </ul>
    </div>
</div>

<div class="card bbs-sidebar">
    <div class="card-header">
        <?= Yii::t('app', 'Hottest') ?>
    </div>
    <div class="card-body">
        <ul class="list">
            <li>Some quick example text to build on the card title and make up the bulk of the card's content.</li>
        </ul>
    </div>
</div>
