<?php

echo $this->render("_nav", [
    'chartId' => $chartId,
    'config' => $config,
    'theme' => $theme,
    'chartConfig' => $chartConfig,
]);

$jsonConfig = \yii\helpers\Json::encode($config);

Yii::$app->view->registerJs(<<<JS
    var chartId = "$chartId";
    var defaultType = "{$config['defaultType']}";
    echartsList[chartId] = echarts.init(document.getElementById(chartId + '-echarts'), "$theme");
    echartsListConfig[chartId] = jQuery.parseJSON('$jsonConfig');
        
    // 动态加载数据
    $('#'+ chartId +' div span').click(function () {
        $(this).parent().find('span').removeClass('orange');
        $(this).addClass('orange');
        var type = $(this).data('type');
        var start = $(this).attr('data-start');
        var end = $(this).attr('data-end');
        var chartId = $(this).parent().parent().attr('id');
        var config = echartsListConfig[chartId];
        
        $.ajax({
            type: "get",
            url: config.server,
            dataType: "json",
            data: {type:type, echarts_type: 'line-graphic', echarts_start: start, echarts_end: end},
            success: function(result){
                var data = result.data;
                if (parseInt(result.code) === 200) {
                     echartsList[chartId].setOption({
                            color: ['#8EC9EB'],
                            legend: {
                                // data:['高度(km)与气温(°C)变化关系']
                            },
                            tooltip: {
                                trigger: 'axis',
                            },
                            grid: {
                                left: '3%',
                                right: '4%',
                                bottom: '3%',
                                containLabel: true
                            },
                            xAxis: {
                                type: 'value',
                                splitLine: {
                                    show: false
                                },
                                axisLabel: {
                                    formatter: '{value}'
                                }
                            },
                            yAxis: {
                                type: 'category',
                                axisLine: {onZero: false},
                                axisLabel: {
                                    formatter: '{value}'
                                },
                                boundaryGap: true,
                                data: data.fieldsName
                            },
                            graphic: [
                                {
                                    type: 'image',
                                    id: 'logo',
                                    right: 20,
                                    top: 20,
                                    z: -10,
                                    bounding: 'raw',
                                    origin: [75, 75]
                                }
                            ],
                            series: data.seriesData
                        }, true);
                } else {
                    rfWarning(result.message);
                }
            }
        });
    });

    // 首个触发点击
    $('#'+ chartId +' div span.' + defaultType).trigger('click');

JS
) ?>