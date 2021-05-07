<?php
use common\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$store = $this->context->store;

$this->title = $store->settings['website_seo_title'] . ' - ' . $store->settings['website_name'] ?: $store->name;
$this->registerMetaTag(["name" => "keywords","content" => $store->settings['website_seo_title']]);
$this->registerMetaTag(["name" => "description","content" => $store->settings['website_seo_description']]);

?>

<div class="row">
    <div class="col-md-9">

        <div class="card">
            <div class="card-header bg-white p-1 pl-3">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">全部</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">新闻</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">资讯</a>
                    </li>
                    <li class="nav-item ml-auto mr-2">
                        <a class="nav-link btn-primary" href="<?= Url::to(['/bbs/topic/edit', 'node_id' => Yii::$app->request->get('id')]) ?>" tabindex="-1" aria-disabled="true"><?= Html::tag('i', '', ['class' => 'bi-pencil']) . ' ' . Yii::t('app', 'Publish') ?></a>
                    </li>
                </ul>
            </div>
            <div class="card-body bg-light border-bottom card-sort">
                <p class="card-text text-right">
                    <?= Yii::t('app', 'Sort') ?>:
                    <?= Html::a(Yii::t('app', 'Newest'), Url::current(['sort' => 'id'])) ?> /
                    <?= Html::a(Yii::t('app', 'Best'), Url::current(['sort' => 'like'])) ?> /
                    <?= Html::a(Yii::t('app', 'Hottest'), Url::current(['sort' => 'click'])) ?>
                </p>
            </div>
            <div class="card-body p-0">

                <?php Pjax::begin([
                    'scrollTo' => 0,
                    'formSelector' => false,
                ]); ?>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'list-group-item'],
                    'summary' => false,
                    'itemView' => '_item',
                    'options' => ['class' => 'list-group'],
                    'pager' => [
                        'options' => ['class' => 'pagination topic-pagination'],
                        'pageCssClass' => 'page-item',
                        'linkOptions' => ['class' => 'page-link'],
                        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link prev disabled'],
                        'maxButtonCount' => 5
                    ],

                ]) ?>
                <?php Pjax::end(); ?>
            </div>
        </div>

    </div>

    <div class="col-md-3">
        <div class="sidebar-fixed">
            <?= \frontend\widgets\BbsSidebar::widget(['type' => 'node']) ?>
        </div>
    </div><!-- /.col-lg-4 -->
</div>
