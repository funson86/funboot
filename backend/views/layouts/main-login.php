<?php
use yii\helpers\Html;
use common\widgets\adminlte\AdminlteLoginAsset;
use backend\assets\AppLoginAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AdminlteLoginAsset::register($this);
AppLoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
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
<body class="hold-transition text-sm login-page">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
