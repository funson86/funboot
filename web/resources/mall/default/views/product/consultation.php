
<?php if (count($data)) { ?>
    <?php foreach ($data as $item) { ?>
    <dl>
        <dt>
        <h3><?= $item->question ?></h3>
        <div class="q-info"> <span class="author"><?= \common\components\StringHelper::hideMiddle($item->username) ?>咨询</span> <span class="time"><?= Yii::$app->formatter->asDatetime($item->created_at) ?></span> </div>
        </dt>
        <dd> <em class="arrow"></em>
            <div class="ans-bd ans-nala cle">
                <div class="author">商城回复：</div>
                <div class="con">
                    <p><?= $item->answer ?></p>
                    <div class="time"><?= Yii::$app->formatter->asDatetime($item->updated_at) ?></div>
                </div>
            </div>
        </dd>
    </dl>
    <?php } ?>
<?php } ?>

<div class="pagination-right">
    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
</div>
