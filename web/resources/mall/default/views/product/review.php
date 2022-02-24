<?php
/** @var $models \common\models\mall\Review[] */
/** @var $pagination \yii\data\Pagination */
?>

<?php if (count($models)) { ?>
    <?php foreach ($models as $item) { ?>
        <div class="consultation-item">
            <h6><span class="tip-qa"><?= Yii::t('mall', 'R') ?></span> <?= $item->content ?></h6>
            <p class="small text-secondary text-right"> <?= \common\helpers\StringHelper::secretName($item->name) ?> <?= Yii::$app->formatter->asDatetime($item->created_at) ?></p>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="text-center"><?= Yii::t('mall', 'No review yet') ?></div>
<?php } ?>

<div class="page-pagination text-right">
    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
</div>
