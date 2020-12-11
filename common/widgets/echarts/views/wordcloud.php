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
    var geoCoordMap;
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
            type:"get",
            url: config.server,
            dataType: "json",
            data: {type:type, echarts_type: 'wordcloud', echarts_start: start, echarts_end: end},
            success: function(result){
                var data = result.data;
                if (parseInt(result.code) === 200) {
                    geoCoordMap = data.geoCoordMapData;
                    echartsList[chartId].setOption({
                        tooltip: {},
                        series: [ {
                            type: 'wordCloud',
                            gridSize: 2,
                            sizeRange: [12, 50],
                            rotationRange: [-90, 90],
                            shape: 'pentagon',
                            width: '100%',
                            height: '100%', 
                            drawOutOfBound: true,
                            textStyle: {
                                normal: {
                                    color: function () {
                                        return 'rgb(' + [
                                            Math.round(Math.random() * 255),
                                            Math.round(Math.random() * 255),
                                            Math.round(Math.random() * 255)
                                        ].join(',') + ')';
                                    },
                                },
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowColor: '#333'
                                }
                            },
                            data: data.seriesData
                        } ]
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