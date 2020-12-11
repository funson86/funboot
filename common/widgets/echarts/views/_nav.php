<?php

use common\helpers\Html;
use kartik\daterange\DateRangePicker;

$addon = <<< HTML
<div class="input-group-append">
    <div class="input-group-text">
        <i class="far fa-calendar-alt"></i>
    </div>
</div>
HTML;

?>

<div class="echarts-body" id="<?= $chartId; ?>">
    <div class="m-b-xl echarts-nav">
        <?php $i = 0; ?>
        <?php foreach ($chartConfig as $key => $value) { ?>
            <?php if ($key == 'custom') { ?>
                <span class="hidden custom" data-type="custom" data-start=""  data-end="" id="freedom-<?= $chartId; ?>"><?= Yii::t('app', 'Cumtom Date') ?></span>
                <div class="input-group drp-container col-lg-3 pull-left" style="margin-left: 10px;width:240px; float: left">
                    <?= DateRangePicker::widget([
                        'name' => 'queryDate-' . $chartId,
                        'value' => '',
                        'useWithAddon' => true,
                        'convertFormat' => true,
                        'startAttribute' => 'start_time',
                        'endAttribute' => 'end_time',
                        'pluginEvents' => [
                            "apply.daterangepicker" => "function(ev, picker) { 
                                var startDate = picker.startDate.format('YYYY-MM-DD');
                                var endDate = picker.endDate.format('YYYY-MM-DD');
                                var chartID = '{$chartId}';
    
                                $('#freedom-' + chartID).attr('data-start', startDate);
                                $('#freedom-' + chartID).attr('data-end', endDate);
                                
                                // 触发点击
                                $('#freedom-' + chartID).trigger('click');
                            }",
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Start Time - End Time')
                        ],
                        'pluginOptions' => [
                            'locale' => ['format' => 'Y-m-d'],
                        ],
                    ]) . $addon;?>
                </div>
            <?php } else { ?>
                <span class="btn btn-default <?= $i == 0 ? 'orange' : '' ?> pointer pull-left <?= Html::encode($key) ?>" data-type="<?= Html::encode($key) ?>"> <?= Html::encode($value) ?></span>
            <?php } ?>
            <?php $i++; ?>
        <?php } ?>
    </div>
    <div class="echarts-chart" style="height: <?= $config['height'] ?>" id="<?= $chartId; ?>-echarts"></div>
    <!-- /.row -->
</div>