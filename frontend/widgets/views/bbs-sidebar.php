<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if ($type == 'topic') { ?>
<div class="card">
    <div class="card-body text-center">
        <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-pencil']) . ' ' . Yii::t('app', 'Publish'), ['/bbs/topic/edit', 'type' => $type, 'node_id' => $nodeId], ['class' => 'btn btn-block btn-primary']) ?>
    </div>
</div>
<?php } ?>

<?php if (count($category) > 0) { ?>
<div class="card bbs-sidebar">
    <div class="card-header">
        <?= Yii::t('app', 'Hottest') ?>
    </div>
    <div class="card-body">
        <ul class="list">
            <?php foreach ($category as $item) { ?>
                <li><?= Html::a($item->name, ['/bbs/topic/view', 'id' => $item->id]) ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>

<?php if (count($excellent) > 0) { ?>
<div class="card bbs-sidebar">
    <div class="card-header">
        <?= Yii::t('app', 'Excellent') ?>
    </div>
    <div class="card-body">
        <ul class="list">
            <?php foreach ($excellent as $item) { ?>
            <li><?= Html::a($item->name, ['/bbs/topic/view', 'id' => $item->id]) ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>
