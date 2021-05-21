<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if (count($models) > 0 && $style == 1) { ?>
<div class="card stuff-sidebar">
    <div class="card-body">
        <ul class="list">
            <?php foreach ($models as $model) { ?>
                <li><?= Html::a($model->content, $model->url) ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>

