<?php
/** @var $models \common\models\mall\Consultation[] */
/** @var $pagination \yii\data\Pagination */
?>

<?php if (count($models)) { ?>
    <?php foreach ($models as $item) { ?>
        <div class="consultation-item">
            <h6><span class="tip-qa"><?= Yii::t('mall', 'Q') ?></span> <?= $item->question ?></h6>
            <p class="small text-secondary text-right"> <?= \common\helpers\StringHelper::secretName($item->name) ?> <?= Yii::$app->formatter->asDatetime($item->created_at) ?></p>
            <p class="pb-0"><span class="tip-qa tip-answer"><?= Yii::t('mall', 'A') ?></span> <?= $item->answer ?></p>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="text-center"><?= Yii::t('mall', 'No consultation yet') ?></div>
<?php } ?>

<p class="tip-change mb-3"><i class="fa fa-lightbulb-o"></i> <?= Yii::t('mall', 'Tips: for the change') ?> </p>

<div class="page-pagination text-right">
    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
</div>
