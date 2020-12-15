<?php
$store = $this->context->store ?? \common\models\Store::findOne(Yii::$app->params['defaultStoreId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $store->settings['website_name'] ?? $store->name ?></title>
    <style>
        .main {
            margin-top: 40px;
            text-align: center;
        }

        .text {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="main">
    <img src="/resources/images/<?= $config['code'] ?>.png" width="50">
    <div class="text"><?= $config['title'] ?></div>
    <div class="text"><?= $config['msg'] ?></div>

    <?php foreach ($config as $k => $v) { ?>
    <div class="text"><?= !in_array($k, ['file', 'code', 'title', 'msg']) ? $v : '' ?></div>
    <?php } ?>
</div>
</body>
</html>