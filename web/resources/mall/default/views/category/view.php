<?php
use common\models\mall\Category;
use common\models\mall\Product;
use yii\helpers\Html;
use common\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\mall\Brand;

/* @var $this yii\web\View */
/* @var $model \common\models\mall\Category */
/* @var $products \common\models\mall\Product[] */
/* @var $pagination  \yii\data\Pagination */
/* @var $priceMinMax array */
/* @var $brandFilter \common\models\mall\Brand[] */

if (!is_null($keyword = Yii::$app->request->get('keyword'))) {
    $this->title = $keyword ? Yii::t('mall', 'Search results contain: ') . $keyword : Yii::t('mall', 'All Products');
    $this->params['breadcrumbs'][] = $this->title;
} else {
    $arrayPath = Category::getCatalogPath($model->id, Yii::$app->cacheSystemMall->getCategories());
    foreach ($arrayPath as $path) {
        $category = Yii::$app->cacheSystemMall->getCategoryById($path);
        $this->params['breadcrumbs'][] = (!next($arrayPath) ? fbt(Category::getTableCode(), $category->id, 'name', $category->name) : ['label' => fbt(Category::getTableCode(), $category->id, 'name', $category->name), 'url' => $this->context->getSeoUrl($category, 'category')]);
    }
    $this->title = fbt(Category::getTableCode(), $category->id, 'name', $category->name);

    $this->registerMetaTag(['name' => 'keywords', 'content' => Html::encode($model->seo_keywords ?: $this->title)]);
    $this->registerMetaTag(['name' => 'description', 'content' => Html::encode($model->seo_description ?: $this->title)]);
}

$store = $this->context->store;

$sort = Yii::$app->request->get('sort');
$pageSize = Yii::$app->request->get('page-size');
?>

<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="shop-sidebar">
                    <?php if (isset($categoriesTree)) { ?>
                    <div class="sidebar-categories">
                        <div class="section-title">
                            <h4><?= Yii::t('app', 'Categories') ?></h4>
                        </div>
                        <div class="categories-accordion">
                            <div class="accordion" id="accordionExample">
                                <?php foreach ($categoriesTree as $item) { ?>
                                <div class="card">
                                    <?php if (count($item['children'])) { ?>
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapse-<?= $item['id'] ?>" class="collapsed" aria-expanded="false"><?= fbt(Category::getTableCode(), $item['id'], 'name', $item['name']) ?></a>
                                    </div>
                                    <div id="collapse-<?= $item['id'] ?>" class="collapse" data-parent="#accordionExample" style="">
                                        <div class="card-body">
                                            <ul>
                                                <?php
                                                foreach ($item['children'] as $child) {
                                                    echo '<li>' . Html::a(fbt(Category::getTableCode(), $child['id'], 'name', $child['name']), $this->context->getSeoUrl($child, 'category'));
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <div class="card-heading-one">
                                        <?= Html::a(fbt(Category::getTableCode(), $item['id'], 'name', $item['name']), $this->context->getSeoUrl($item, 'category')) ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="sidebar-filter">
                        <div class="section-title">
                            <h4><?= Yii::t('mall', 'Filter by Price') ?></h4>
                        </div>
                        <div class="filter-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="<?= isset($priceMinMax['min']) ? floor($priceMinMax['min']) : 0 ?>" data-max="<?= isset($priceMinMax['max']) ? ceil($priceMinMax['max']) : 10000 ?>"></div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <p><?= Yii::t('mall', 'Price:') ?></p>
                                    <input type="text" id="minAmount">
                                    <input type="text" id="maxAmount">
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" data-url="<?= Yii::$app->request->getUrl() ?>" class="btn-filter-price"><?= Yii::t('app', 'Filter') ?></a>
                    </div>

                    <?php if (count($brandFilter) > 0) { ?>
                    <div class="sidebar-brand">
                        <div class="section-title">
                            <h4><?= Yii::t('mall', 'Filter by Brand') ?></h4>
                        </div>
                        <div class="sidebar-brand-list">
                            <?php foreach ($brandFilter as $item) { ?>
                            <a href="<?= Url::current(['brand_id' => $item['id']]) ?>" class="<?= $item['id'] == Yii::$app->request->get('brand_id') ? 'active': '' ?>"><?= fbt(Brand::getTableCode(), $item['id'], 'name', $item['name']) ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <div class="col-12">
                        <div class="product-top-bar">
                            <div class="product-top-bar-inner">
                                <h2><?= $this->title ?> (<?= $pagination->totalCount ?>)</h2>
                            </div>
                            <div class="product-top-bar-inner">
                                <div class="product-bar-single">
                                    <select id="product-sort">
                                        <option value=""><?= Yii::t('mall', 'Sort By') ?></option>
                                        <option value="<?= Url::current(['sort' => '-sales']) ?>" <?= $sort == '-id' ? 'selected="selected"' : '' ?>><?= Yii::t('mall', 'Best Selling') ?></option>
                                        <option value="<?= Url::current(['sort' => 'price']) ?>" <?= $sort == '-id' ? 'selected="selected"' : '' ?>><?= Yii::t('mall', 'Price, low to high') ?></option>
                                        <option value="<?= Url::current(['sort' => '-price']) ?>" <?= $sort == 'id' ? 'selected="selected"' : '' ?>><?= Yii::t('mall', 'Price, high to low') ?></option>
                                        <option value="<?= Url::current(['sort' => '-id']) ?>" <?= $sort == '-id' ? 'selected="selected"' : '' ?>><?= Yii::t('mall', 'Date, new to old') ?></option>
                                        <option value="<?= Url::current(['sort' => 'id']) ?>" <?= $sort == 'id' ? 'selected="selected"' : '' ?>><?= Yii::t('mall', 'Date, old to new') ?></option>
                                    </select>
                                </div>
                                <div class="product-bar-single">
                                    <select id="product-page-size">
                                        <option value="<?= Url::current(['page-size' => '12']) ?>" <?= $pageSize == '12' ? 'selected="selected"' : '' ?>><?= Yii::t('mall', 'Show 12') ?></option>
                                        <option value="<?= Url::current(['page-size' => '18']) ?>" <?= $pageSize == '18' ? 'selected="selected"' : '' ?>><?= Yii::t('mall', 'Show 18') ?></option>
                                        <option value="<?= Url::current(['page-size' => '24']) ?>" <?= $pageSize == '24' ? 'selected="selected"' : '' ?>><?= Yii::t('mall', 'Show 24') ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($products as $product) { ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="product-item">
                            <div class="product-item-pic set-bg" data-setbg="<?= $this->context->getImage($product->thumb) ?>">
                                <div class="label new"><?= Yii::t('mall', 'New') ?></div>
                                <ul class="product-hover">
                                    <li><a href="<?= $this->context->getImage($product->image) ?>" data-fancybox="gallery"><i class="fa fa-expand"></i></a></li>
                                    <li><a href="<?= $this->context->getSeoUrl($product) ?>"><i class="fa fa-shopping-bag"></i></a></li>
                                </ul>
                            </div>
                            <div class="product-item-text">
                                <h6><?= Html::a(fbt(Product::getTableCode(), $product->id, 'name', $product->name), $this->context->getSeoUrl($product)) ?></h6>
                                <div class="rating">
                                    <?= \common\helpers\UiHelper::renderStar($product->star) ?>
                                </div>
                                <div class="product-price"><?= $this->context->getNumberByCurrency($product->price) ?></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="col-lg-12 text-center category-view-pagination">
                        <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination, 'options' => ['class' => 'pagination-option']]) ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function () {
    var rangeSlider = $(".price-range"),
        minAmount = $("#minAmount"),
        maxAmount = $("#maxAmount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');

    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minAmount.val(ui.values[0]);
            maxAmount.val(ui.values[1]);
        }
    });
    minAmount.val(rangeSlider.slider("values", 0));
    maxAmount.val(rangeSlider.slider("values", 1));
});

$('.product-bar-single select').change(function () {
    window.location.href = $(this).val();
})

$('.btn-filter-price').click(function () {
    window.location.href = changeURLArg($(this).data('url'), 'price', $("#minAmount").val() + ',' + $("#maxAmount").val());
})
</script>
