
<?php if (count($portlet) > 1) { ?>
    <div class="main-content-menu-content list-main-content-menu-content">
        <?php foreach ($portlet as $item) { ?>
            <li>
                <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/' . $item['type'], 'id' => $item['id']]) ?>" class="<?php if ($item['id'] == Yii::$app->request->get('id')) { echo 'active';} ?>"><?= $item['name'] ?></a>
            </li>
        <?php } ?>
    </div>
<?php } ?>
