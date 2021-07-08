<?php
use frontend\helpers\Url;
?>

<?php if (count($portlet) > 1) { ?>

<div class="card list-main-content-menu-content mb-4">
    <div class="card-header">
        <a href="<?= Url::to(['/cms/default/' . $root['type'], 'id' => $root['id']], false, Yii::$app->language) ?>"><?= $root['name'] ?></a>
    </div>
    <div class="card-body">
        <ul class="list">
            <?php foreach ($portlet as $item) { ?>
                <li><a href="<?= Url::to(['/cms/default/' . $item['type'], 'id' => $item['id']], false, Yii::$app->language) ?>" class="<?= $item['id'] == $catalogId ? 'active' : ''; ?>"><?= $item['name'] ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php } ?>
