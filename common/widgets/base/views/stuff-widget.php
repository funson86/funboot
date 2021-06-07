<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if (count($models) > 0 && $style == 1) { ?>
<div class="card stuff-sidebar">
    <div class="card-body">
        <ul class="list">
            <?php foreach ($models as $model) { ?>
                <li><?= Html::a($model->content, Url::to(['/site/stuff-redirect', 'url' => $model->url]), ['target' => '_blank']) ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>

<?php if (count($models) > 0 && $style == 2) { ?>
    <?php foreach ($models as $model) { ?>
    <?= Html::a(Html::img($model->content, ['class' => 'img-fluid img-square']), Url::to(['/site/stuff-redirect', 'url' => $model->url]), ['target' => '_blank']) ?>
    <?php } ?>
<?php } ?>

<?php if (count($models) > 0 && $style == 3) { ?>
    <?php foreach ($models as $model) { ?>
    <?= Html::tag('span', Html::a($model->content, Url::to(['/site/stuff-redirect', 'url' => $model->url]), ['target' => '_blank'])) ?>
    <?php } ?>
<?php } ?>
