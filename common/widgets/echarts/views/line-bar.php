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
            data: {type:type, echarts_type: 'line-bar', echarts_start: start, echarts_end: end},
            success: function(result){
                var data = result.data;
                if (parseInt(result.code) === 200) {
                    echartsList[chartId].setOption({
                        title : {
                            text: '',
                            subtext: ''
                        },
                        legend: {
                            show: true,
                            data: data.fieldsName
                        },
                        tooltip : {
                            trigger: 'axis'
                        },
                        toolbox: {
                            show : true,
                            feature : {
                                mark : {show: false},
                                dataView : {show: false, readOnly: false},
                                magicType : {show: true, type: ['line', 'bar']},
                                restore : {show: false},
                                saveAsImage : {show: false}
                            }
                        },
                        calculable : true,
                        xAxis : [
                            {
                                type : 'category',
                                boundaryGap : false,
                                data : data.xAxisData
                            }
                        ],
                        yAxis : [
                            {
                                type : 'value',
                                axisLabel : {
                                    formatter: '{value}'
                                },
                            }
                        ],
                        series : data.seriesData,
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