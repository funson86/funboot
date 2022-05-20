<?php

use common\helpers\Html;
use common\models\tool\RedisCrud as ActiveModel;
use common\models\base\SettingType;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $models \common\models\Store[] */

$this->title = Yii::t('app', 'Monitor');
$this->params['breadcrumbs'][] = $this->title;

$settingTypeCodeName = ArrayHelper::map(SettingType::find()->all(), 'code', 'name');

function buildSettings($settings, $prefix = 'website_', $settingTypeCodeName = []) {
    foreach ($settings as $code => $value) {
        if (strpos($code, $prefix) === 0 && $value) {
            echo Yii::t('setting', ($settingTypeCodeName[$code] ?? '-')) . ': ' . $value . '<br>';
        }
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= $this->title ?></h2>
                <div class="card-tools">
                    <?= Yii::t('app', 'Count') . ': ' . count($models) ?>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th><?= Yii::t('app', 'Name') ?></th>
                        <th><?= Yii::t('app', 'Website') ?></th>
                        <th><?= Yii::t('app', 'Contact') ?></th>
                        <th><?= Yii::t('app', 'System') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($models as $model) { $settings = Yii::$app->settingSystem->getSettings($model->id); ?>
                        <tr data-key="<?= $model->id ?>">
                            <td><?= implode('<br>', [$model->id, $model->host_name, $model->user->username, $model->user->email]) ?></td>
                            <td><?= buildSettings($settings, 'website_', $settingTypeCodeName) ?></td>
                            <td><?= buildSettings($settings, 'contact_', $settingTypeCodeName) ?></td>
                            <td><?= buildSettings($settings, 'system_', $settingTypeCodeName) ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
