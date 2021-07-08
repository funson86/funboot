<?php
use frontend\helpers\Url;
?>

<?php if (count($portlet) > 1) { ?>
    <div class="sub-menu list-sub-menu">
        <ul class="sub-menu-content list-sub-menu-content">
            <li><a href="<?= Url::to(['/cms/default/' . $root['type'], 'id' => $root['id']], false, Yii::$app->language) ?>" class="<?= $root['id'] == $catalogId ? 'active' : '' ?>"><?= $root['name'] ?></a></li>

            <?php foreach ($portlet as $item) { ?>
            <li><a href="<?= Url::to(['/cms/default/' . $item['type'], 'id' => $item['id']], false, Yii::$app->language) ?>" class="<?= $item['id'] == $catalogId ? 'active' : ''; ?>"><?= $item['name'] ?></a></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
