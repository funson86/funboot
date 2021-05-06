

<?php if (count($data)) { ?>
    <?php foreach ($data as $item) { ?>
    <div class="z-com cle" id="comment_id_<?= $item->id ?>">
        <div class="z-com-left"> <img class="face_img" src="/images/default.png"> <span class="u-name" title="<?= \common\components\StringHelper::hideMiddle($item->username) ?>"><?= \common\components\StringHelper::hideMiddle($item->username) ?></span> <!--span class="vip-ico vip-ico-img"></span--> </div>
        <div class="z-com-right">
            <div class="left_arrow"> <i class="left_arrow-line">◆</i> <i class="left_arrow-bg">◆</i> </div>
            <div class="z-com-right-head cle"> <span class="min_star"><cite class="ping_star"><i style="width:<?= Yii::$app->formatter->asPercent($item->star / 5) ?>;"></i></cite></span> <span class="com-time"><?= Yii::$app->formatter->asDatetime($item->created_at) ?> </span> </div>
            <div class="z-coms" id="comment_id_<?= $item->id ?>">
                <div class="z-coms-text">
                    <div class="user-com cle"><span> <?= $item->content ?></span> </div>
                </div>
                <div class="z-coms-other cle"> <span class="z-com-click"> <a href="javascript:;" class="up" data-link="<?= Yii::$app->urlManager->createUrl(['/comment/ajax-up', 'id' => $item->id]) ?>">赞（<i><?= $item->up ?></i>）</a> <!--a href="javascript:;" class="reply"   data-id="3231657" data-user="15021162568">回应（<i class="comnum">0</i>）</a> </span--> </div>
            </div>
        </div>
    </div>
    <?php } ?>
<?php } ?>

<div class="pagination-right">
    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
</div>
