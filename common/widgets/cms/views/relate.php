<?php if (is_array($models) && count($models) > 0) { ?>
    <div class="main-content-menu-relate list-main-content-menu-relate">
        <div class="main-content-menu-relate-block list-main-content-menu-relate-block">为您推荐</div>
        <ul class="main-content-menu-relate-ul">
            <?php foreach ($models as $model) { ?>
                <li class="main-content-menu-relate-title list-main-content-menu-relate-title">
                    <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/page', 'id' => $model['id']]) ?>"><?= $model['name'] ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
