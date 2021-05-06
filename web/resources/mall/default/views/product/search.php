<?php
/* @var $this yii\web\View */

$this->registerCssFile('@web/css/search.css', ['depends' => \frontend\assets\AppAsset::className()]);
?>

<div id="wrapper">

<div class="main cle">

<?php if (!count($products)) { ?>
<div class="search-none">
    <div class="bd">
        <h4>很抱歉，没有找到与&nbsp;“<i class="red"><?= Yii::$app->request->get('keyword') ?></i>”&nbsp;相关的商品。你可以换一个关键词试试</h4>
        <p>1、看看输入的文字是否有误</p>
        <p>2、去掉可能不必要的字词，如“的”、“什么”等</p>
        <p>3、调整关键字，如“牛栏奶粉”改成“牛栏”或“奶粉”</p>
    </div>
    <div id="search-arrow" class="search-arrow"></div>
</div>
<?php } else { ?>
    <div class="search-selected"> <span class="search-min-nav"> <a href="<?= Yii::$app->urlManager->createUrl(['product/search']) ?>">全部</a> &gt; <a href="<?= Yii::$app->urlManager->createUrl(['product/search', 'keyword' => Yii::$app->request->get('keyword')]) ?>"><?= Yii::$app->request->get('keyword') ?></a> </span> </div>
    <div class="search_items">
        <ul class="cle">
            <?php if (count($products)) { foreach ($products as $item) { ?>
                <li>
                    <div class="pic">
                        <a target="_blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['product/view', 'id' => $item->id]) ?>">
                            <img alt="<?= $item->name ?>" src="<?= $item->thumb ?>" style="display: inline;"/>
                            <p class="mask">
								<span>
									<i class="iconfont">BUY!</i>
									<br>
									立即购买
								</span>
                            </p>
                        </a>
                    </div>

                    <div class="info">
                        <h5>
                            <a target="_blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['product/view', 'id' => $item->id]) ?>"><?php echo $item->name ?>
                            </a>
                        </h5>

                        <div class="p_btn cle">
					<span class="price">
					￥
						<strong><?php echo $item->price ?></strong>
					</span>

					<span class="old">
						<del>￥<?php echo $item->market_price ?></del>
					</span>

					<span class="sales">
						<img src="http://7xkwre.com1.z0.glb.clouddn.com/sales.png" alt="代购奶粉销量" />
                        <?php echo $item->sales ?>
					</span>
                            <a class="btn fr" target="_blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['product/view', 'id' => $item->id]) ?>">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                        </div>

                        <p class="country">
                            <?php if($item->origin->image===''){
                                $item->origin->image = 'http://7xkwre.com1.z0.glb.clouddn.com/United%20Kingdom(Great%20Britain).png';
                            }
                            ?>

                            <img src="<?= $item->origin->image ?>" alt="<?=$item->name?>" />
                        </p>
                </li>
            <?php }} else {?>
                <li style="width:100%;height:300px;">很抱歉，没有找到相关的商品，请联系我们的客服或者选择我们的海淘转运服务！</li>
            <?php } ?>
        </ul>
    </div>
    <div id="pagenav" class="pagenav">
        <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
<?php } ?>
</div>
</div>
