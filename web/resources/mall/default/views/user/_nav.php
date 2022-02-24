<?php
use yii\helpers\Url;

/** @var $type String */

?>


<ul class="nav nav-tabs card-header-tabs user-card-header-tabs">
    <li class="nav-item"><a href="<?= Url::to(['/mall/user/order']) ?>" class="nav-link <?= $type == 'order' ? 'active' : '' ?>"> <i class="fa fa-file-text"></i> <span><?= Yii::t('app', 'Order') ?></span></a></li>
    <li class="nav-item"><a href="<?= Url::to(['/mall/user/coupon']) ?>" class="nav-link <?= $type == 'coupon' ? 'active' : '' ?>"><i class="fa fa-money"></i> <span><?= Yii::t('app', 'Coupon') ?></span></a></li>
    <li class="nav-item"><a href="<?= Url::to(['/mall/user/favorite']) ?>" class="nav-link <?= $type == 'favorite' ? 'active' : '' ?>"><i class="fa fa-heart"></i> <span><?= Yii::t('app', 'Favorite') ?></span></a></li>
    <li class="nav-item"><a href="<?= Url::to(['/mall/user/address']) ?>" class="nav-link <?= $type == 'address' ? 'active' : '' ?>"><i class="fa fa-map-marker"></i> <span><?= Yii::t('app', 'Address') ?></span></a></li>
    <li class="nav-item"><a href="<?= Url::to(['/mall/user/setting']) ?>" class="nav-link <?= $type == 'setting' ? 'active' : '' ?>"><i class="fa fa-lock"></i> <span><?= Yii::t('app', 'Setting') ?></span></a></li>
</ul>
