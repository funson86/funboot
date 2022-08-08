<?php

use common\helpers\ArrayHelper;
use common\helpers\Html;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$statusLabels = $this->context->modelClass::getStatusLabels(null, true);
$typeLabels = $this->context->modelClass::getTypeLabels(null, true);
?>

<style>
    .select-on-check-all { display: none; }
    .dropdown-options label { display: block; margin: .2rem 0 0 0; }
</style>

<div class="section-filter mb-sm-2">
    <div class="btn-group">
        <button type="button" class="btn-selection btn btn-default btn-current"><?= Yii::t('app', 'Current Page') ?>(<?= min($dataProvider->count, $dataProvider->pagination->getPageSize()) ?>)</button>
        <button type="button" class="btn-selection btn btn-default btn-filter"><?= Yii::t('app', 'All Filter') ?>(<?= $dataProvider->totalCount ?>)</button>
        <button type="button" class="btn-selection btn btn-filter-active btn-cancel"><?= Yii::t('app', 'Cancel All') ?></button>
    </div>
    <?= Html::export(null, [], Yii::t('app', 'Export '), ['class' => 'ml-3 btn btn-default btn-sm'], false) ?>
    <?= Html::a(Yii::t('app', 'Delete'), "javascript:void(0);", ['class' => 'ml-3 btn btn-default btn-sm delete-selection']); ?>

    <div class="btn-group ml-3 btn-group-status">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><?= Yii::t('app', 'Status') ?></button>
        <div class="dropdown-menu">
            <div class="px-4 py-1 dropdown-options status-items">
                <?= Html::radioList('status', key($statusLabels), $statusLabels, ['class' => '', 'itemOptions' => ['class' => 'form-group']]) ?>
            </div>
            <div class="dropdown-divider"></div>
            <div class="text-center"><button class="btn btn-primary status-selection"><?= Yii::t('app', 'Submit') ?></button></div>
        </div>
    </div>

    <div class="btn-group ml-3 btn-group-type">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><?= Yii::t('app', 'Type') ?></button>
        <div class="dropdown-menu">
            <div class="px-4 py-1 dropdown-options type-items">
                <?php if (in_array('type', $this->context->filterMultipleFields)) { ?>
                <?= Html::checkboxList('type', null, $typeLabels, ['class' => '', 'itemOptions' => ['class' => 'form-group']]) ?>
                <?php } else { ?>
                <?= Html::radioList('type', key($typeLabels), $typeLabels, ['class' => '', 'itemOptions' => ['class' => 'form-group']]) ?>
                <?php } ?>
            </div>
            <div class="dropdown-divider"></div>
            <div class="text-center"><button class="btn btn-primary type-selection"><?= Yii::t('app', 'Submit') ?></button></div>
        </div>
    </div>

</div>

<?php
$csrfToken = Yii::$app->request->getCsrfToken();

$query = clone $dataProvider->query;
$idsFilter = ArrayHelper::getColumn($query->select(['id'])->asArray()->all(), 'id');
$jsonIdsFilter = json_encode($idsFilter);

$totalCount = $dataProvider->totalCount;

$urlDelete = Url::to(['delete', 'soft' => false]);
$urlStatus = Url::to(['edit-ajax-status']);
$urlField = Url::to(['edit-ajax-field']);
$js = <<<JS
    var isAllFilter = false;

    $(document).ready(function () {
        $('.summary').append('<span class="selection-info"></span>')
        $('.selection-info').html(0 + fbT(' items selected'));
    })

    $('.btn-current').click(function () {
        $('.btn-selection').removeClass('btn-filter-active').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-filter-active');
        $(".grid-view tbody input[type='checkbox']").each(function () {
            $(this).prop('checked', true);
        });
        isAllFilter = false;
        let count = $(".grid-view tbody input[type='checkbox']:checked").length;
        $('.selection-info').html(count + fbT(' items selected'));
    })

    $('.btn-filter').click(function () {
        $('.btn-selection').removeClass('btn-filter-active').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-filter-active');
        $(".grid-view tbody input[type='checkbox']").each(function () {
            $(this).prop('checked', true);
        });
        isAllFilter = true;
        $('.selection-info').html({$totalCount} + fbT(' items selected'));
    })

    $('.btn-cancel').click(function () {
        $('.btn-selection').removeClass('btn-filter-active').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-filter-active');
        $(".grid-view tbody input[type='checkbox']").each(function () {
            $(this).prop('checked', false);
        });
        isAllFilter = false;
        let count = $(".grid-view tbody input[type='checkbox']:checked").length;
        $('.selection-info').html(count + fbT(' items selected'));
    })

    $(".grid-view tbody input[type='checkbox']").change(function () {
        $('.btn-selection').removeClass('btn-filter-active').addClass('btn-default');
        $('.btn-cancel').removeClass('btn-default').addClass('btn-filter-active');
        isAllFilter = false;
        let count = $(".grid-view tbody input[type='checkbox']:checked").length;
        $('.selection-info').html(count + fbT(' items selected'));
    })

    $('.delete-selection').click(function () {
        url = "{$urlDelete}";
        if (isAllFilter) {
            ids = {$jsonIdsFilter};
        } else {
            ids = $(".grid-view").yiiGridView("getSelectedRows");
        }

        sendRequest(url, ids);
    });

    $('.status-selection').click(function () {
        url = "{$urlStatus}" + '?status=' + $('.status-items input:checked').val();
        if (isAllFilter) {
            ids = {$jsonIdsFilter};
        } else {
            ids = $(".grid-view").yiiGridView("getSelectedRows");
        }

        sendRequest(url, ids);
    });

    $('.type-selection').click(function () {
        let value = 0;
        $(".type-items input:checked").each(function () {
            value += parseInt($(this).val());
        });

        url = "{$urlField}" + '?field=type&value=' + value;
        if (isAllFilter) {
            ids = {$jsonIdsFilter};
        } else {
            ids = $(".grid-view").yiiGridView("getSelectedRows");
        }

        sendRequest(url, ids);
    });

    function sendRequest(url, ids) {
        if (ids.length === 0) {
            fbError(fbT('Select at least 1 item first'));
            return false;
        }

        let param = {
            'ids' : ids.toString(),
            '_csrf-backend' : '{$csrfToken}'
        };
        $.post(url, param, function(data) {
            if (parseInt(data.code) !== 200) {
                fbError(data.msg);
            } else {
                Swal.fire({title: data.msg, confirmButtonText: fbT('Ok'),}).then(function () {
                    window.location.reload();
                });
            }
        }, "json");
    }

    $('.export-selection').click(function () {
        url = $(this).data('url');
        if (isAllFilter) {
            ids = {$jsonIdsFilter};
        } else {
            ids = $(".grid-view").yiiGridView("getSelectedRows");
        }

        if (ids.length === 0) {
            fbError(fbT('Select at least 1 item first'));
            return false;
        }
        postLink(url, {'_csrf-backend': '{$csrfToken}', 'ids': ids.toString()});
    });

JS;

$this->registerJs($js, \yii\web\View::POS_END);
