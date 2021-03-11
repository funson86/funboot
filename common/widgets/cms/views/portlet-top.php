
<?php if (count($portlet) > 1) { ?>
    <div class="sub-menu list-sub-menu">
        <ul class="sub-menu-content list-sub-menu-content">
            <li>
                <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/' . $root['type'], 'id' => $root['id']]) ?>" class="<?php if ($root['id'] == Yii::$app->request->get('id')) { echo 'active';} ?>"><?= $root['name'] ?></a>
            </li>
            <?php foreach ($portlet as $item) { ?>
                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['cms/default/' . $item['type'], 'id' => $item['id']]) ?>" class="<?php if ($item['id'] == Yii::$app->request->get('id')) { echo 'active';} ?>"><?= $item['name'] ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
