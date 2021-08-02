<?php

use common\helpers\Html;
use yii\helpers\Inflector;
use common\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\ModelSearch */

$this->title = Yii::t('app', 'System Info');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"><?= !is_null($this->title) ? Html::encode($this->title) : Inflector::camelize($this->context->id);?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['index', 'type' => 'php']) ?>"><?= Yii::t('app', 'PHP Info') ?></a>
                    </li>
                </ul>
            </div>
            <div class="card-body">

                <h3 class="card-title pt-3 pb-3"><i class="fa fa-cog"></i> <?= Yii::t('system', 'Server Info') ?></h3>
                <table class="table">
                    <tr>
                        <td><?= Yii::t('system', 'Server Domain IP') ?></td>
                        <td><?= $model['environment']['domainIP'] ?></td>
                        <td><?= Yii::t('system', 'Server Flag') ?></td>
                        <td><?= $model['environment']['flag'] ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Server OS') ?></td>
                        <td><?= $model['environment']['os'] ?></td>
                        <td><?= Yii::t('system', 'Server Engine') ?></td>
                        <td><?= $model['environment']['serverEngine'] ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Server Language') ?></td>
                        <td><?= $model['environment']['language'] ?></td>
                        <td><?= Yii::t('system', 'Server Port') ?></td>
                        <td><?= $model['environment']['serverPort'] ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Server Name') ?></td>
                        <td><?= $model['environment']['name'] ?></td>
                        <td><?= Yii::t('system', 'Server Document Root') ?></td>
                        <td><?= $model['environment']['webPath'] ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Server Time') ?></td>
                        <td><span id="divTime"></span></td>
                        <td><?= Yii::t('system', 'Server Up Time') ?></td>
                        <td><?= floor(intval($model['uptime']) / 86400) . Yii::t('app', ' Days ') .  floor(intval($model['uptime']) % 86400 / 3600) . Yii::t('app', ' Hours ') .  floor(intval($model['uptime']) % 86400 % 3600 / 60) . Yii::t('app', ' Minutes ') .  floor(intval($model['uptime']) % 86400 % 3600 % 60) . Yii::t('app', ' Seconds ') ?></td>
                    </tr>
                </table>

                <h3 class="card-title pt-3 pb-3"><i class="fas fa-chart-area"></i> <?= Yii::t('system', 'CPU/MEMORY Usage') ?></h3>
                <table class="table">
                    <tr>
                        <td colspan="4">
                            <div id="cpuChart" style="width: 100%; height:400px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Cpu Cores') ?></td>
                        <td><?= $model['cpu']['cpuCores'] ?></td>
                        <td><?= Yii::t('system', 'Total Memory') ?></td>
                        <td><?= $model['memory']['totalMem'] ?>M</td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Cpu Model') ?></td>
                        <td><?= $model['cpu']['cpuModel'] ?></td>
                        <td><?= Yii::t('system', 'Used Memory') ?></td>
                        <td><?= $model['memory']['usedMem'] ?>M</td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Cpu Vendor') ?></td>
                        <td><?= $model['cpu']['cpuVendor'] ?></td>
                        <td><?= Yii::t('system', 'Total Swap') ?></td>
                        <td><?= $model['memory']['totalSwap'] ?>M</td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Load Avg') ?></td>
                        <td id="loadAvg"><?= $model['loadavg']['explain'] ?></td>
                        <td><?= Yii::t('system', 'Used Swap') ?></td>
                        <td><?= $model['memory']['usedSwap'] ?>M</td>
                    </tr>
                </table>

                <h3 class="card-title pt-3 pb-3"><i class="fas fa-chart-line"></i> <?= Yii::t('system', 'Server Net Info') ?></h3>
                <table class="table">
                    <tr>
                        <td colspan="4">
                            <div id="netChart" style="width: 100%; height:400px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'All Output') ?></td>
                        <td id="net_allOutputSpeed"><?= $model['net']['allOutputSpeed'] ?></td>
                        <td><?= Yii::t('system', 'All Input') ?></td>
                        <td id="net_allInputSpeed"><?= $model['net']['allInputSpeed'] ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('system', 'Output Speed') ?></td>
                        <td id="net_currentOutputSpeed"><?= $model['net']['currentOutputSpeed'] ?></td>
                        <td><?= Yii::t('system', 'Input Speed') ?></td>
                        <td id="net_currentInputSpeed"><?= $model['net']['currentInputSpeed'] ?></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile('@staticUrl/resources/plugins/echarts/echarts.min.js');
$strChartTime = json_encode($model['chartTime']);
$urlSystemIndex = Url::to(['index']);
$js = <<<JS
    var cpuChart = echarts.init(document.getElementById('cpuChart'));
    var netChart = echarts.init(document.getElementById('netChart'));
    var cpuUsage = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var memUsage = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var currentOutputSpeed = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var currentInputSpeed = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var chartTime = $strChartTime;

    function chartOptionCpu() {
        var option = {
            title : {
                subtext: fbT('Cpu/Memory Usage')
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['Cpu', fbT('Memory')]
            },
            toolbox: {
                show : false,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : chartTime
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'Cpu',
                    type:'line',
                    smooth:true,
                    data:cpuUsage
                },
                {
                    name:fbT('Memory'),
                    type:'line',
                    smooth:true,
                    data:memUsage
                }
            ]
        };

        return option;
    }

    function chartOptionNet() {
        var option = {
            title : {
                subtext: fbT('Unit KB/s')
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:[fbT('Output Speed'), fbT('Input Speed')]
            },
            toolbox: {
                show : false,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : chartTime
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:fbT('Output Speed'),
                    type:'line',
                    smooth:true,
                    data:currentOutputSpeed
                },
                {
                    name:fbT('Input Speed'),
                    type:'line',
                    smooth:true,
                    data:currentInputSpeed
                }
            ]
        };

        return option;
    }

    cpuChart.setOption(chartOptionCpu()); // 加载图表
    netChart.setOption(chartOptionNet()); // 加载图表

    $(document).ready(function(){
        setTime();
        setInterval(setTime, 1000);
        setInterval(getServerInfo, 5000);
    });

    function setTime() {
        var d = new Date(), str = '';
        str += d.getFullYear() + '-'; // 获取当前年份
        str += d.getMonth() + 1 + '-'; // 获取当前月份（0——11）
        str += d.getDate() + ' ';
        str += d.getHours() + ':';
        str += d.getMinutes() + ':';
        str += d.getSeconds() + '';
        $("#divTime").text(str);
    }

    function getServerInfo() {
        $.ajax({
            type : "get",
            url  : "$urlSystemIndex",
            dataType : "json",
            data: {},
            success: function(data) {
                if (data.code == 200) {
                    var data = data.data;
                    $('#loadAvg').html(data.loadavg.explain);

                    // cpu内存图表
                    cpuUsage.shift();
                    memUsage.shift();
                    cpuUsage.push(data.cpu.cpuUsage);
                    memUsage.push(data.memory.memUsage);
                    chartTime = data.chartTime;
                    cpuChart.setOption(chartOptionCpu());

                    // 网络图表
                    var net = data.net;
                    $('#net_allOutputSpeed').text(net.allOutputSpeed + ' G');
                    $('#net_allInputSpeed').text(net.allInputSpeed + ' G');
                    $('#net_currentOutputSpeed').text(net.currentOutputSpeed + ' KB/s');
                    $('#net_currentInputSpeed').text(net.currentInputSpeed + ' KB/s');

                    currentOutputSpeed.shift();
                    currentInputSpeed.shift();
                    currentOutputSpeed.push(net.currentOutputSpeed);
                    currentInputSpeed.push(net.currentInputSpeed);
                    chartTime = data.chartTime;
                    netChart.setOption(chartOptionNet());

                } else {
                    fbPrompt(data.message);
                }
            }
        });
    }
JS;

$this->registerJs($js, \yii\web\View::POS_END);
