<?php
use common\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use common\models\base\Stuff;

/* @var $this yii\web\View */

$store = $this->context->store;

$this->title = $store->settings['website_seo_title'];
$this->registerMetaTag(["name" => "keywords", "content" => $store->settings['website_seo_title']]);
$this->registerMetaTag(["name" => "description", "content" => $store->settings['website_seo_description']]);

?>

<div class="row">
    <div class="col-md-9">

        <div class="card">
            <?php if (!empty($listChildren)) { ?>
            <div class="card-header bg-white p-1 pl-3">
                <ul class="nav nav-pills card-header-pills">
                    <?php foreach ($listChildren as $item) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $item['id'] == Yii::$app->request->get('id') ? 'active' : '' ?>" href="<?= Url::to(['/bbs/default/index', 'id' => $item['id']]) ?>"><?= $item['name'] ?></a>
                    </li>
                    <?php } ?>
                    <li class="nav-item ml-auto mr-2">
                        <a class="nav-link btn-primary" href="<?= Url::to(['/bbs/topic/edit', 'node_id' => Yii::$app->request->get('id')]) ?>" tabindex="-1" aria-disabled="true"><?= Html::tag('i', '', ['class' => 'bi-pencil']) . ' ' . Yii::t('app', 'Publish') ?></a>
                    </li>
                </ul>
            </div>
            <?php } ?>
            <div class="card-body bg-light border-bottom card-sort">
                <p class="card-text text-right">
                    <span class="float-left top-ads">
                        <?= \common\widgets\base\StuffWidget::widget(['style' => 3, 'codeId' => Yii::$app->request->get('id', '1'), 'position' => Stuff::POSITION_TOP, 'type' => Stuff::TYPE_TEXT, 'limit' => 2]) ?>
                    </span>
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
            <?= \common\widgets\base\StuffWidget::widget(['style' => 2, 'codeId' => Yii::$app->request->get('id', '1'), 'position' => Stuff::POSITION_RIGHT, 'type' => Stuff::TYPE_IMAGE]) ?>
        </div>
    </div><!-- /.col-lg-4 -->
</div>
