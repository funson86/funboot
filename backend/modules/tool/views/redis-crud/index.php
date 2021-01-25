<?php

use common\helpers\Html;
use common\models\tool\RedisCrud as ActiveModel;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */
/* @var int $type */

$this->title = Yii::t('app', 'Redis Crud');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= $this->title ?></h2>
                <div class="card-tools">
                    <?= Html::createModal() ?>
                    <?= Html::export() ?>
                    <?= Html::import() ?>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?= Yii::t('app', 'Name') ?></th>
                        <th><?= Yii::t('app', 'Type') ?></th>
                        <th><?= Yii::t('app', 'Sort') ?></th>
                        <th><?= Yii::t('app', 'Status') ?></th>
                        <th><?= Yii::t('app', 'Created At') ?></th>
                        <th><?= Yii::t('app', 'Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($models as $model) { ?>
                        <tr data-key="<?= $model['id'] ?>">
                            <td><?= $model['id'] ?></td>
                            <td><?= Html::field('name', $model['name']) ?></td>
                            <td><?= ActiveModel::getTypeLabels($model['type']) ?></td>
                            <td><?= Html::sort($model['sort']) ?></td>
                            <td><?= Html::status($model['status']) ?></td>
                            <td><?= date('Y-m-d H:i:s', $model['created_at']) ?></td>
                            <td>
                                <?= Html::viewModal(['view-ajax', 'id' => $model['id']]); ?>
                                <?= Html::editModal(['edit-ajax', 'id' => $model['id']]); ?>
                                <?= Html::delete(['delete', 'id' => $model['id'], 'soft' => false]); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <p>
                    <?= \yii\widgets\LinkPager::widget([
                        'pagination' => $pages
                    ]);?>
                </p>
            </div>
        </div>
    </div>
</div>
