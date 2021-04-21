<?php

use common\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\enums\YesNo;
use common\models\base\Setting as ActiveModel;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\base\Setting */
/* @var $form yii\widgets\ActiveForm */
/* @var $settingTypes array */

$this->title = (isset($model->id) ? Yii::t('app', 'Edit') : Yii::t('app', 'Create')) . Yii::t('app', 'Setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row pt-3 pb-5">
    <div class="col-md-2 col-sm-2 col-xs-2 pr-0">
        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
            <?php foreach ($settingTypes as $k => $settingType) { ?>
            <a class="nav-link <?php if ($k == 0) echo 'active'; ?>" data-toggle="pill" href="#setting_type_<?= $settingType['id'] ?>" role="tab" aria-selected="false"><?= Yii::t('setting', $settingType['name']) ?></a>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-7 col-sm-10 col-xs-10 bg-white" style="border-radius: 3px; border: 1px solid #dee2e6; border-left: none">
        <div class="tab-content p-3" id="vert-tabs-tabContent">
            <?php foreach ($settingTypes as $k => $settingType) { ?>
            <div class="tab-pane text-left fade <?php if ($k == 0) echo 'active show'; ?>" id="setting_type_<?= $settingType['id'] ?>" role="tabpanel">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-tab-' . $settingType['id']
                    ]); ?>
                    <?php foreach ($settingType['children'] as $setting) {  if (count($setting['children']) > 0) { ?>
                        <h2 style="font-size: 18px;padding-top: 0;margin-top: 0">
                            <i class="icon ion-android-apps"></i><?= Yii::t('setting', $setting['name']) ?>
                        </h2>
                        <div class="col-sm-12 pl-3">
                            <?php foreach ($setting['children'] as $row) { ?>
                                <?= $this->render($row['type'], [
                                    'row' => $row,
                                    'valueRange' => \common\helpers\StringHelper::parseAttr($row['value_range']),
                                    'valueDefault' => $row['value_default'],
                                ]) ?>
                            <?php } ?>
                        </div>
                    <?php } else { $row = $setting; ?>
                    <div class="col-sm-12 pl-3">
                        <?= $this->render($row['type'], [
                            'row' => $row,
                            'valueRange' => \common\helpers\StringHelper::parseAttr($row['value_range']),
                            'valueDefault' => $row['value_default'],
                        ]) ?>
                    </div>
                    <?php } } ?>
                    <div class="col-sm-12 pl-3 form-group clearfix">
                        <div class="col-sm-12 text-center">
                            <span type="submit" class="btn btn-primary" onclick="editAjaxSave(<?= $settingType['id'] ?>)"><?= Yii::t('app', 'Save') ?></span>
                            <?= Html::export() ?>
                            <?= Html::import() ?>
                            <?php if ($this->context->isAdmin()) { ?>
                            <?= Html::buttonModal(['export-all'], Yii::t('app', 'Export All'), ['class' => 'btn btn-sm btn-primary'], false); ?>
                            <?= Html::buttonModal(['import-repair-setting-type'], Yii::t('app', 'Repair'), ['class' => 'btn btn-sm btn-warning'], false); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-3 hidden-sm hidden-xs pl-3" id="settingDesc">
        <div class="card">
            <div class="card-body">
                <h5 class="text-red"><?= Yii::t('app', 'Click Save button below after modification') ?></h5>
                <h5><?= Yii::t('app', 'Description') ?></h5>
                <p><?= Yii::t('app', 'Click label to get setting code') ?></p>
                <div class="hr-line-dashed"></div>
                <h5 class="tag-title"></h5>
                <?= Html::input('text', 'settingCode', '', ['class' => 'form-control', 'id' => 'settingCode', 'readonly' => 'readonly']); ?>
                <div class="hr-line-dashed"></div>
                <div class="clearfix"><?= Yii::t('app', 'Code') ?>:  <span id="settingName">-</span></div>
            </div>
        </div>
    </div>
</div>

<script>
    // 单击显示代码
    $('.form-check-label').click(function () {
        $('#settingCode').val($(this).attr('for'));
        $('#settingName').text($(this).text());
    });

    function editAjaxSave(id) {
        let values = $("#form-tab-" + id).serializeObject();
        $.ajax({
            type: "post",
            url: "<?= Url::to(['edit-ajax-save'])?>",
            dataType: "json",
            data: values,
            success: function (data) {
                if (data.code === 200) {
                    fbSuccess(data.msg);
                } else {
                    fbError(data.msg);
                }
            }
        });
    }

    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        var $radio = $('input[type=radio],input[type=checkbox]',this);
        $.each($radio,function(){
            if(!o.hasOwnProperty(this.name)){
                o[this.name] = '';
            }
        });
        return o;
    };
</script>
