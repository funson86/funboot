<?php
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\base\Lang;
use frontend\helpers\Url;

$context = $this->context;
$store = $this->context->store;

NavBar::begin([
//     'brandLabel' => Html::img('/images/logo.png'),
    'brandLabel' => $this->context->store->settings['website_name'] ?: $this->context->store->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark fixed-top',
    ],
]);

// 语言
$languages = [];
foreach (Lang::getLanguageCode() as $id => $code) {
    if (($store->lang_frontend & $id) == $id) {
        $languages[] = ['label' => '<i class="flag-icon flag-icon-' . Lang::getLanguageFlag($id) . ' mr-2"></i>' . Lang::getLanguageLabels($id), 'url' => Url::attachLang($code)];
    }
}
$menuItems[] = [
    'label' => Html::tag('i', '', ['class' => 'flag-icon flag-icon-' . Lang::getLanguageFlag(Lang::getLanguageCode(Yii::$app->language, true, true))]) . ' ' . Lang::getLanguageCodeLabels(Yii::$app->language),
    'items' => $languages,
];

echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav'],
    'items' => $menuItems,
    'activateParents' => true,
]);

$menuItems = [
    ['label' => Yii::t('app', 'Home'), 'url' => Url::to(['/', ])],
    ['label' => Yii::t('app', 'Online Pay'), 'url' => Url::to(['/pay/default/pay', ])],
    ['label' => Yii::t('app', 'Donate List'), 'url' => Url::to(['/pay/default/list', ])],
    ['label' => Yii::t('app', 'Funboot Platform'), 'url' => 'https://github.com/funson86/funboot/'],
];

echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $menuItems,
    'activateParents' => true,
]);
NavBar::end();

?>
<script>
    function _scroll(){
        var scrollTop = $(window).scrollTop();
        if (scrollTop < 10){
            $('.navbar').removeClass('bg-dark');
            $('.navbar').css('opacity', 1);
        } else {
            $('.navbar').addClass('bg-dark');
            $('.navbar').css('opacity', 0.95);
        }
    }
    $(window).on('scroll',function() {
        _scroll()
    });

    // 解决手机点击下拉部分透明，下拉后有背景
    $('.navbar-toggler').click(function () {
        if ($('#navbarCollapse').hasClass('show')) {
            $('.navbar').removeClass('bg-dark');
            $('.navbar').css('opacity', 1);
        } else {
            $('.navbar').addClass('bg-dark');
            $('.navbar').css('opacity', 0.95);
        }
    })

</script>


<?php if ($style == 'other') { ?>

    <header class="masthead" style="height: 20vh; min-height: 20vh">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 text-center my-auto">
                    <h5 class="mt-3">代码开源 免费使用 无需签约 容易部署</h5>
                </div>
            </div>
        </div>
    </header>
<?php } ?>
