<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\ImageHelper;
use common\models\mall\Category;
use common\models\mall\Product;
use common\models\mall\Attribute;
use common\models\mall\AttributeItem;
use common\models\mall\Param;

/* @var $this yii\web\View */
/* @var $allParams \common\models\mall\Param[] */
/* @var $attributes \common\models\mall\Attribute[] */
/* @var $jsonProductAttribute string */

$arrayPath = Category::getCatalogPath($model->category_id, Yii::$app->cacheSystemMall->getCategories());
foreach ($arrayPath as $path) {
    $category = Yii::$app->cacheSystemMall->getCategoryById($path);
    $this->params['breadcrumbs'][] = ['label' => fbt(Category::getTableCode(), $category->id, 'name', $category->name), 'url' => $this->context->getSeoUrl($category, 'category')];
}
$this->params['breadcrumbs'][] = fbt(Product::getTableCode(), $model->id, 'name', $model->name);
$this->title = fbt(Product::getTableCode(), $model->id, 'name', $model->name);

$this->registerMetaTag(['name' => 'keywords', 'content' => Html::encode($model->seo_keywords ?: $this->title)]);
$this->registerMetaTag(['name' => 'description', 'content' => Html::encode($model->seo_description ?: $this->title)]);

$arrDefaultAttribute = [];
?>

<section class="page-section product-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="product-details-pic">
                    <div class="product-details-pic-item">
                        <img class="product-details-pic-item-large" src="<?= $this->context->getImage($model->image) ?>">
                    </div>
                    <div class="product-details-pic-slider owl-carousel">
                        <img data-imgbigurl="<?= $this->context->getImage($model->image) ?>" src="<?= $this->context->getImage($model->thumb) ?>">
                        <?php if (is_array($model->images)) { foreach ($model->images as $item) { ?>
                        <img data-imgbigurl="<?= $this->context->getImage($item) ?>" src="<?= $this->context->getImage($item) ?>">
                        <?php } } ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="product-details-text">
                    <h3><?= fbt(Product::getTableCode(), $model->id, 'name', $model->name) ?></h3>
                    <div class="product-details-rating">
                        <?= \common\helpers\UiHelper::renderStar($model->star) ?>
                        <span>(<?= $model->reviews ?> <?= Yii::t('app', 'Reviews') ?>)</span>
                    </div>
                    <div class="product-details-price"><?= $this->context->getNumberByCurrency($model->price) ?></div>
                    <p><?= fbt(Product::getTableCode(), $model->id, 'brief', $model->brief) ?></p>
                    <ul id="product-attribute">
                        <?php foreach ($attributes as $attribute) { ?>
                        <li>
                            <b><?= fbt(Attribute::getTableCode(), $attribute->id, 'name', $attribute->name) ?></b>
                            <div id="attribute-<?= $attribute->id; ?>" class="attribute-btn attribute-btn-<?= $attribute['type'] ?>">
                                <?php foreach ($attribute->attributeItems as $key => $attributeItem) { $key == 0 && array_push($arrDefaultAttribute, $attributeItem['id']); ?>
                                    <?php if ($attribute['type'] == Attribute::TYPE_COLOR) { ?>
                                        <label for="attribute-item-<?= $attributeItem['id'] ?>" class="<?= $key == 0 ? 'active' : '' ?>">
                                            <input type="radio" name="attribute-item-<?= $attributeItem['attribute_id'] ?>" id="attribute-item-<?= $attributeItem['id'] ?>" <?= $key == 0 ? 'checked="checked"' : '' ?> value="<?= $attributeItem['id'] ?>">
                                            <span class="checkmark" style="background-color: #<?= $mapProductAttributeItemAttributeItemIdLabel[$attributeItem['id']] ?? '000' ?>"></span>
                                        </label>
                                    <?php } elseif ($attribute['type'] == 3) { ?>
                                        <label for="attribute-item-<?= $attributeItem['id'] ?>" class="<?= $key == 0 ? 'active' : '' ?>" style="background-image: url(<?= $mapProductAttributeItemAttributeItemIdLabel[$attributeItem['id']] ?? ImageHelper::get('/resources/images/add-sku.png'); ?>)">
                                            <input type="radio" name="attribute-item-<?= $attributeItem['attribute_id'] ?>" id="attribute-item-<?= $attributeItem['id'] ?>" <?= $key == 0 ? 'checked="checked"' : '' ?> value="<?= $attributeItem['id'] ?>">
                                        </label>
                                    <?php } else { ?>
                                        <label for="attribute-item-<?= $attributeItem['id'] ?>" class="<?= $key == 0 ? 'active' : '' ?>">
                                            <input type="radio" name="attribute-item-<?= $attributeItem['attribute_id'] ?>" id="attribute-item-<?= $attributeItem['id'] ?>" <?= $key == 0 ? 'checked="checked"' : '' ?> value="<?= $attributeItem['id'] ?>">
                                            <?= fbt(AttributeItem::getTableCode(), $attributeItem['id'], 'name', $attributeItem['name']) ?>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>

                    <div class="product-details-quantity mt-3">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="text" id="product-number" value="1">
                            </div>
                        </div>
                    </div>
                    <a href="javascript:" id="addToCart" class="cart-btn"><i class="fa fa-shopping-bag"></i> <?= Yii::t('mall', 'Add to Cart') ?></a>
                    <a href="javascript:" class="heart-icon"><i class="fa fa-heart-o"></i></a>

                    <ul class="border-0">
                        <li><b><?= Yii::t('mall', 'Promotions') ?></b> <span><?= Yii::t('mall', 'Free shipping') ?></span></li>
                        <li><b><?= Yii::t('mall', 'Share on') ?></b>
                            <div class="share">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="col-lg-12">
                <div class="product-details-tab">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="nav-content-tab" data-toggle="tab" href="#nav-content" role="tab" aria-controls="nav-content" aria-selected="true"><?= Yii::t('mall', 'Details') ?></a>
                            <a class="nav-link" id="nav-review-tab" data-toggle="tab" href="#nav-review" role="tab" aria-controls="nav-review" aria-selected="false"><?= Yii::t('mall', 'Reviews') ?></a>
                            <a class="nav-link" id="nav-consultation-tab" data-toggle="tab" href="#nav-consultation" role="tab" aria-controls="nav-consultation" aria-selected="false"><?= Yii::t('mall', 'Consultations') ?></a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-content" role="tabpanel" aria-labelledby="nav-content-tab">
                            <?= fbt(Product::getTableCode(), $model->id, 'content', $model->content) ?>

                            <h3 class="content-param"><?= Yii::t('mall', 'Product Params') ?></h3>
                            <table class="table table-bordered">
                                <?php if (is_array($allParams)) { foreach ($allParams as $child2) { ?>
                                    <tr><td rowspan="<?= count($child2->children) == 0 ? 1 : count($child2->children) ?>"><?= fbt(Param::getTableCode(), $child2->id, 'name', $child2->name) ?></td>
                                    <?php $i = 0; if (isset($child2->children) && is_array($child2->children) && count($child2->children)) { foreach ($child2->children as $child3) { ?>
                                        <?php if ($i == 0) { ?>
                                            <td><?= fbt(Param::getTableCode(), $child3->id, 'name', $child3->name) ?><td><?= Yii::t('param', $mapProductParamIdContent[$child3->id] ?? '-') ?></td>
                                        <?php } else { ?>
                                            <tr><td><?= fbt(Param::getTableCode(), $child3->id, 'name', $child3->name) ?><td><?= Yii::t('param', $mapProductParamIdContent[$child3->id] ?? '-') ?></td></tr>
                                        <?php } $i++; ?>
                                    <?php } } else { ?>
                                        <td width="50%"><?= Yii::t('param', $mapProductParamIdContent[$child2->id] ?? '-') ?></td>
                                    <?php } ?>
                                    </tr>
                                <?php } } ?>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                            <div class="review-list"></div>
                        </div>

                        <div class="tab-pane fade" id="nav-consultation" role="tabpanel" aria-labelledby="nav-consultation-tab">
                            <div class="card mb-5">
                                <div class="card-header">
                                    <?= Yii::t('app', 'Consultation') ?>
                                </div>
                                <div class="card-body text-right">
                                    <textarea id="consultation-question" cols="4" class="form-control mb-2" placeholder="<?= Yii::t('mall', 'Add your question here') ?>"></textarea>
                                    <button class="btn btn-primary" id="consultation-btn"><?= Yii::t('app', 'Submit') ?></button>
                                </div>
                            </div>
                            <div class="consultation-list"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</section>

<?php sort($arrDefaultAttribute); ?>

<script>
var strProductAttribute = '<?= $jsonProductAttribute ?>';
var objProductAttribute = JSON.parse(strProductAttribute);
var inStock = false;

var urlLogin = '<?= Url::to(['/mall/default/login', 'returnUrl' => Yii::$app->request->getUrl()]) ?>';
var login = <?= Yii::$app->user->isGuest ? 'false' : 'true' ?>;

$(document).ready(function() {
    $(".product-details-pic-slider").owlCarousel({
        loop: true,
        margin: 20,
        items: <?= (is_array($model->images) ? count($model->images) : 0) + 1 ?>,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });

    $.get('<?= Url::to(['/mall/product/favorite', 'product_id' => $model->id]) ?>', function(data, status) {
        if (data.data === 1) {
            $(".heart-icon").addClass('heart-icon-active');
        }
    }, "json")

    $.get('<?= Url::to(['/mall/product/review', 'product_id' => $model->id]) ?>', function(data, status) {
        if (data.code === 200) {
            $(".review-list").html(data.data);
        } else {
            Swal.fire(data.msg);
        }
    }, "json")

    $.get('<?= Url::to(['/mall/product/consultation', 'product_id' => $model->id]) ?>', function(data, status) {
        if (data.code === 200) {
            $(".consultation-list").html(data.data);
        } else {
            Swal.fire(data.msg);
        }
    }, "json")

    <?php if (count($arrDefaultAttribute)) { ?>
    try {
        let objAttributeInfo = objProductAttribute['<?= implode(',', $arrDefaultAttribute) ?>'];
        console.log(objAttributeInfo);
        if (objAttributeInfo.price !== undefined) {
            $('.product-details-price').html(objAttributeInfo.price);
            if (parseInt(objAttributeInfo.stock) < 1) {
                inStock = false;
                $('#addToCart').addClass('inactive');
            } else {
                inStock = true;
                $('#addToCart').removeClass('inactive');
            }
        }
    } catch (e) {
        console.log(e);
    }
    <?php } else { ?>
        inStock = <?= $model->stock ?>;
    <?php } ?>
});

$('.heart-icon').click(function() {
    if (!login) {
        window.location.href = urlLogin;
        return;
    }
    let param = {
        product_id: <?= $model->id ?>,
        _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
    };
    $.post('<?= Url::to(['/mall/product/favorite']) ?>', param, function(data) {
        if (data.code !== 200) {
            alert(data.msg);
            return;
        }

        if (data.data === 1) {
            $(".heart-icon").addClass('heart-icon-active');
        } else {
            $(".heart-icon").removeClass('heart-icon-active');
        }
    }, "json");
})

$("#consultation-btn").click(function() {
    if (!login) {
        window.location.href = urlLogin;
        return;
    }
    let param = {
        product_id : <?= $model->id ?>,
        question : $("#consultation-question").val(),
        _csrf : '<?= Yii::$app->request->getCsrfToken() ?>'
    };
    $.post('<?= Url::to(['/mall/product/consultation']) ?>', param, function(data) {
        if (data.code !== 200) {
            Swal.fire(data.msg);
            return;
        }
        Swal.fire(data.msg);
    }, "json");
});

$('.review-list').on('click', '.pagination a', function(e){
    e.preventDefault();
    $.get({
        url: $(this).attr('href'),
        success: function(data){
            $('.review-list').html(data.data);
        }

    }, "json");
});

$('.consultation-list').on('click', '.pagination a', function(e){
    e.preventDefault();
    $.get({
        url: $(this).attr('href'),
        success: function(data){
            $('.consultation-list').html(data.data);
        }

    }, "json");
});

$('.product-details-pic-slider img').on('click', function () {

    var imgurl = $(this).data('imgbigurl');
    var bigImg = $('.product-details-pic-item-large').attr('src');
    if (imgurl != bigImg) {
        $('.product-details-pic-item-large').attr({
            src: imgurl
        });
    }
});

$('#nav-tab a').on('click', function (event) {
    event.preventDefault()
    $(this).tab('show')
})

$(".attribute-btn label").on('click', function () {
    $(this).parent().find("label").removeClass('active');
    $(this).addClass('active');
});

$("#addToCart").on('click', function () {
    if (!inStock) {
        return;
    }

    let selectAttributes = [];
    $('.attribute-btn').find('input:checked').each(function () {
        selectAttributes.push($(this).val());
        // alert($(this).val())
    })
    selectAttributes.sort();
    console.log(selectAttributes.join(','));
    $(this).addClass('inactive');
    $(this).find('i').remove();
    $(this).prepend('<img src="/resources/images/loading.gif" />');
    let param = {
        product_id: <?= $model->id ?>,
        number: $("#product-number").val(),
        product_attribute_value: selectAttributes.join(','),
        _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
    };
    $.post('<?= Url::to(['/mall/cart/edit-ajax']) ?>', param, function(data) {
        if (data.code === 200) {
            window.location.href = "<?= Url::to(['/mall/cart']) ?>";
        } else {
            alert(data.msg);
        }
    }, "json");

});

// 选择属性后判断价格和库存
$('#product-attribute input').click(function () {
    let selectAttributes = [];
    $('.attribute-btn').find('input:checked').each(function () {
        selectAttributes.push($(this).val());
    })
    selectAttributes.sort();

    let objAttributeInfo = objProductAttribute[selectAttributes.join(',')];
    // console.log(parseInt(objAttributeInfo));
    $('.product-details-price').html(objAttributeInfo.price);
    if (parseInt(objAttributeInfo.stock) < 1) {
        inStock = false;
        $('#addToCart').addClass('inactive');
    } else {
        inStock = true;
        $('#addToCart').removeClass('inactive');
    }
})
</script>
