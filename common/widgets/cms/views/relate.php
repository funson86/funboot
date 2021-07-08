<?php
use frontend\helpers\Url;
?>

<?php if (is_array($models) && count($models) > 0) { ?>
<div class="card list-main-content-menu-relate mb-4">
    <div class="card-header">
        <?= Yii::t('app', 'Recommended') ?>
    </div>
    <div class="card-body">
        <ul class="list">
            <?php foreach ($models as $model) { ?>
                <li><a href="<?= Url::to(['/cms/default/page', 'id' => $model['id']], false, Yii::$app->language) ?>"><?= $model['name'] ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>
