<?php
use yii\helpers\Html;
use common\helpers\Url;
use common\helpers\ImageHelper;
use common\models\base\Log;
use common\models\Store;

$store = $this->context->store;

?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <?php foreach (\common\helpers\ArrayHelper::tree(Yii::$app->authSystem->userPermissions) as $item) { ?>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="javascript:;" class="nav-link fbTopNav" data-id="<?= $item['id'] ?>" >
                <i class="nav-icon fas <?= strlen($item['icon']) > 0 ? $item['icon'] : 'fa-circle-o' ?>"></i> <?= Yii::t('permission', $item['name']) ?></span>
            </a>
        </li>
        <?php } ?>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown" id="headerMessage">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge" id="unreadMessageCount"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="<?= Url::to(['message/index'], false, false) ?>" class="dropdown-item dropdown-footer J_menuItem" onclick="$('body').click();"><?= Yii::t('app', 'View all messages') ?></a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown <?= Yii::$app->user->id != 1 ? 'hidden' : '' ?>">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="logCount"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!--span class="dropdown-item dropdown-header">15 Notifications</span-->
                <div class="dropdown-divider"></div>
                <a href="<?= Url::to(['base/log/index', 'type' => Log::TYPE_ERROR]) ?>" class="dropdown-item J_menuItem" onclick="$('body').click();">
                    <i class="fas fa-exclamation-triangle mr-2"></i> <span id="logErrorCount">0</span> <?= Yii::t('app', 'new error logs') ?>
                    <!--span class="float-right text-muted text-sm">3 mins</span-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= Url::to(['base/log/index', 'type' => Log::TYPE_LOGIN]) ?>" class="dropdown-item J_menuItem" onclick="$('body').click();">
                    <i class="fas fa-user mr-2"></i> <span id="logLoginCount">0</span> <?= Yii::t('app', 'new login logs') ?>
                    <!--span class="float-right text-muted text-sm">12 hours</span-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= Url::to(['base/log/index', 'type' => Log::TYPE_DB]) ?>" class="dropdown-item J_menuItem" onclick="$('body').click();">
                    <i class="fas fa-database mr-2"></i> <span id="logDbCount">0</span> <?= Yii::t('app', 'new database logs') ?>
                    <!--span class="float-right text-muted text-sm">2 days</span-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= Url::to(['base/log/index']) ?>" class="dropdown-item dropdown-footer J_menuItem"><?= Yii::t('app', 'View All Logs') ?></a>
            </div>
        </li>

        <!-- user -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?= ImageHelper::getAvatar() ?>" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?= Yii::$app->user->identity->username ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="<?= ImageHelper::getAvatar() ?>" class="img-circle elevation-2" alt="User Image">

                    <p>
                        <?= Yii::$app->user->identity->username; ?>
                        <small><?= Yii::$app->request->userIP; ?></small>
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <a href="<?= Url::to(['/site/me']); ?>" class="J_menuItem" onclick="$('body').click();"><?= Yii::t('app', 'Profile'); ?></a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="<?= Url::to(['/site/change-password']); ?>" class="J_menuItem" onclick="$('body').click();"><?= Yii::t('app', 'Modify Password'); ?></a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                    </div>
                    <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat" data-methods="post" onclick="fbPrompt('<?= Url::to(['/site/clear-cache']); ?>'); return false;"><?= Yii::t('app', 'Clear Cache'); ?></a>
                    <a href="<?= Url::to(['site/logout']); ?>" data-method="post" class="btn btn-default btn-flat float-right"><?= Yii::t('app', 'Logout'); ?></a>
                </li>
            </ul>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="flag-icon flag-icon-<?= Yii::$app->language == 'zh-CN' ? 'cn' : 'gb' ?>"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <?php if (($store->language & Store::LANGUAGE_EN) == Store::LANGUAGE_EN) { ?>
                <a href="javascript:;" class="dropdown-item funboot-lang" data-lang="en">
                    <i class="flag-icon flag-icon-gb mr-2"></i> <?= Yii::t('app', 'English') ?>
                </a>
                <?php } ?>
                <?php if (($store->language & Store::LANGUAGE_ZH_CN) == Store::LANGUAGE_ZH_CN) { ?>
                <a href="javascript:;" class="dropdown-item funboot-lang" data-lang="zh-CN">
                    <i class="flag-icon flag-icon-cn mr-2"></i> <?= Yii::t('app', 'Chinese') ?>
                </a>
                <?php } ?>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<script type="text/html" id="topMessage">
    <div class="dropdown-item" data-index="{{id}}">
        <div class="media">
            <img src="{{avatar}}" alt="r" class="img-size-50 mr-3 img-circle">
            <div class="media-body">
                <h3 class="dropdown-item-title">
                    {{username}}
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">{{name}}</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{created_at}}</p>
            </div>
        </div>
    </div>
</script>

<?php
$urlSetLanguage = Url::to(['site/set-language'], false, false);
$urlMessageList = Url::to(['message/list'], false, false);
$urlSiteLog = Url::to(['site/log'], false, false);
$js = <<<JS
$(document).ready(function(){
    getMessageList();
});
$('.funboot-lang').click(function() {
    let lang = $(this).data('lang')
    let param = {
        lang: lang
    }
    $.post("{$urlSetLanguage}", param, function(data) {
        if (parseInt(data.code) === 200) {
            window.location.reload();
        }
    })
});
function getMessageList() {
    $.ajax({
        type: "get",
        url: "{$urlMessageList}",
        dataType: "json",
        success: function (data) {
            if (parseInt(data.code) === 200) {
                if (parseInt(data.map.unread) > 0) {
                    $('#unreadMessageCount').html(data.map.unread);
                    messageWarning(fbT('New Message'))
                }

                let items = data.data;
                for (let i = 0; i < items.length; i++) {
                    // 增加显示
                    let callData = [];
                    callData["id"] = items[i].id;
                    callData["url"] = items[i].url;
                    callData["avatar"] = items[i].avatar;
                    callData["username"] = items[i].username;
                    callData["name"] = items[i].name;
                    callData["created_at"] = items[i].created_at;
                    let html = template('topMessage', callData);
                    $('#headerMessage .dropdown-divider').before(html);
                }
            }
        }
    });
}
JS;

$this->registerJs($js);

$js = <<<JS
$(document).ready(function(){
    getSiteLog();
});
function getSiteLog() {
    $.ajax({
        type: "get",
        url: "{$urlSiteLog}",
        dataType: "json",
        success: function (data) {
            if (parseInt(data.code) === 200) {
                $('#logErrorCount').html(data.data.logErrorCount);
                $('#logLoginCount').html(data.data.logLoginCount);
                $('#logDbCount').html(data.data.logDbCount);
                $('#logCount').html(data.data.logCount);
            }
        }
    });
}
JS;

if (true) {
    $this->registerJs($js);
}

