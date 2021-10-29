<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\base\Lang;
use common\helpers\ArrayHelper;

$store = $this->context->store;

$strLang = '';
foreach (Lang::getLanguageCode() as $id => $code) {
    if (($store->lang_frontend & $id) == $id) {
        $strLang .= '<div class="lang_store">' . Html::a('<i class="flag-icon flag-icon-' . Lang::getLanguageFlag($id) .'"></i> '. Lang::getLanguageLabels($id), \frontend\helpers\Url::attachLang($code)) . '</div>';
    }
}

$currencies = json_decode(Yii::$app->settingSystem->getValue('mall_currencies'), true);
$mapCurrency = ArrayHelper::map($currencies, 'code', 'symbol');

$currencyDefault = Yii::$app->settingSystem->getValue('mall_currency_default');
$currencyCurrent = Yii::$app->session->get('currencyCurrent', $currencyDefault);
$strCurrencyCurrent = ($mapCurrency[$currencyDefault] ?? '') . $currencyCurrent;

$strCurrency = '';
foreach ($currencies as $item) {
    $strCurrency .= '<div class="currency_store" data-code="' . $item['code'] . '">' . Html::tag('span', ($mapCurrency[$item['code']] ?? ''). $item['code']) . '</div>';
}

// vd(Yii::$app->session->get('currencyCurrent'));
?>

<div class="top_bar">
    <div class="top_bar_bd cle">
        <ul class="welcome">
            <li class="top_lang">
                <span class="top_items"><i class="flag-icon flag-icon-<?= Lang::getLanguageFlag(Lang::getLanguageCode(Yii::$app->language, true, true)) ?>"></i> <?= Lang::getLanguageCodeLabels(Yii::$app->language) ?></span>
                <div class="lang_list">
                    <?= $strLang ?>
                </div>
            </li>

            <li class="top_currency">
                <span class="top_items"><?= $strCurrencyCurrent ?></span>
                <?php if (strlen($strCurrency) > 0) { ?>
                <div class="currency_list">
                    <?= $strCurrency ?>
                </div>
                <? } ?>
            </li>
        </ul>
        <ul id="top_user_info">
            <li id="header_user">
                <?php if (Yii::$app->user->isGuest) { ?>
                    <a href="<?= Url::to(['/mall/default/login']) ?>" rel="nofollow"><?= Yii::t('app', 'Login') ?></a> <a href="<?= Url::to(['/mall/default/signup']) ?>" rel="nofollow"><?= Yii::t('app', 'Sign up') ?></a>
                <?php } else { ?>
                    <a class="" href="<?= Url::to(['/mall/user']) ?>"><?= Yii::$app->user->identity->username ?></a>&nbsp;[<a href="<?= Url::to(['/site/logout']) ?>"><?= Yii::t('app', 'Logout') ?></a>]
                <?php } ?>
            </li>
            <li><a href="<?= Url::to(['/mall/order']) ?>"><?= Yii::t('app', 'Orders') ?></a></li>
            <li><a href="<?= Url::to(['/mall/user/favorite']) ?>"><?= Yii::t('app', 'Favorites') ?></a></a></li>
            <!--<li><a class="menu-link" href="<?= Url::to(['/cms/default/page', 'id' => 11, 'surname' => 'register']) ?>">帮助中心</a></li>-->
        </ul>
    </div>
</div>

<div class="top_main cle">
    <div class="logo">
        <p>
            <a href="<?= Yii::$app->homeUrl ?>" class="top_logo">商城</a>
        </p>
    </div>
    <div class="search_box">
        <form action="<?= Url::to(['/mall/product/search']) ?>" method="get" id="searchForm" name="searchForm" >
            <input class="sea_input" type="text" name="keyword" id="searchText" value="<?= Yii::$app->request->get('keyword') ?>" placeholder="<?= Yii::t('app', '请输入商品') ?>" />
            <button type="submit" class="sea_submit"><i class="iconfont fa fa-search"></i></button>
        </form>
    </div>
    <div class="top_search_hot">
        <a class="red" href="<?= Url::to(['/mall/product/search', 'keyword' => '爱他美']) ?>" target="_blank">爱他美</a>
        <a href="<?= Url::to(['/mall/product/search', 'keyword' => '牛栏']) ?>">牛栏</a>
        <a href="<?= Url::to(['/mall/product/search', 'keyword' => '辅食']) ?>">辅食</a>
        <a class="red" href="<?= Url::to(['/mall/product/search', 'keyword' => '面霜']) ?>">面霜</a>
        <a href="<?= Url::to(['/mall/product/search', 'keyword' => '鱼油']) ?>">鱼油</a>
        <a class="red" href="<?= Url::to(['/mall/product/search', 'keyword' => '奶粉']) ?>" target="_blank">奶粉</a>
    </div>
</div>

<?php
$urlSetCurrency = Url::to(['/mall/default/set-currency']);
$js = <<<JS
jQuery("#searchForm").submit(function(){
    if (jQuery("#searchText").val() == '') {
        return false;
    }
});
jQuery(".currency_store").click(function(){
    let code = $(this).data('code')
    let param = {
        currency: code
    }
    $.get("{$urlSetCurrency}", param, function(data) {
        if (parseInt(data.code) === 200) {
            window.location.reload();
        }
    })
});
JS;

$this->registerJs($js);
?>
