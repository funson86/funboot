<?php
/* @var $this yii\web\View */

$this->registerCssFile('@web/css/brand.css', ['depends' => \frontend\assets\AppAsset::className()]);
$this->title = "所有品牌-家家优品代购海淘商城";
?>

<div id="wrapper">

<div class="main cle">
    <div class="search-selected"> <span class="search-min-nav"> <a href="<?= Yii::$app->urlManager->createUrl(['brand/search']) ?>">所有品牌</a> &gt; <a href="<?= Yii::$app->urlManager->createUrl(['/mall/product/search', 'keyword' => Yii::$app->request->get('keyword')]) ?>"><?= Yii::$app->request->get('keyword') ?></a> </span> </div>
    <br/>
    <div class="brands_items">
        <ul class="cle">
            <?php if (count($allBrands)) { foreach ($allBrands as $item) { ?>
                <li>
                	<a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['brand/view', 'id' => $item->id])?>">
                		<img src="<?= $item->logo ?>" alt="<?= $item->name?>"/>
                	</a>
                </li>
            <?php }} else {?>
                <li style="width:100%;height:300px;">很抱歉，因为故障没有显示任何的品牌信息，请联系我们的客服！</li>
            <?php } ?>
        </ul>
    </div>
</div>
</div>
