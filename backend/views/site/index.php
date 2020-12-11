<?php

/* @var $this yii\web\View */

use common\widgets\adminlte\AdminlteAsset;
use yii\helpers\Html;

$this->title = $this->context->store->name;

AdminlteAsset::register($this);
backend\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini text-sm">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php'
        ) ?>

        <?= $this->render(
            'left.php'
        )
        ?>

        <?= $this->render(
            'content.php'
        ) ?>

        <script>
            // 配置
            let config = {
                tag: "<?= Yii::$app->params['sys_tags'] ?? false; ?>",
                isMobile: <?= \common\helpers\CommonHelper::isMobile() ? 'true' : 'false' ?>
            };
        </script>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>

