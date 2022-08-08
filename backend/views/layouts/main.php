<?php

use yii\helpers\Html;
use backend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
    <script>
        // 配置
        let config = {
            tag: "<?= Yii::$app->params['sys_tags'] ?? false; ?>",
            isMobile: <?= \common\helpers\CommonHelper::isMobile() ? 'true' : 'false' ?>
        };
    </script>
    <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini text-sm">
<?php $this->beginBody() ?>
<div class="wrapper" style="background: #f4f6f9">

    <?= $this->render('content', [
        'content' => $content
    ]) ?>

    <?= $this->render('footer') ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
