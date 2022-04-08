<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\components\enums\YesNo;
use common\models\wechat\Tag as ActiveModel;
use yii\helpers\Inflector;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'Tags');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?> <?= Html::aHelp(Yii::$app->params['helpUrl'][Yii::$app->language][$this->context->module->id . '_' . $this->context->id] ?? null) ?></h2>
                <div class="card-tools">
                    <?= Html::buttonModal(['edit-sync'], Yii::t('app', 'Sync All'), ['class' => 'btn btn-success'], false) ?>
                    <?= Html::createModal() ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?= Yii::t('app', 'Name') ?></th>
                        <th><?= Yii::t('app', 'Fan Count') ?></th>
                        <th><?= Yii::t('app', 'Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($models as $model) { ?>
                        <tr data-key="<?= $model['id'] ?>">
                            <td><?= $model['id'] ?></td>
                            <td><?= Html::field('name', $model['name']) ?></td>
                            <td><?= $model['count'] ?></td>
                            <td>
                                <?= Html::delete(['delete', 'id' => $model['id'], 'soft' => false]); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
