<?php

namespace common\widgets\echarts;

use common\helpers\ArrayHelper;
use common\helpers\IdHelper;
use common\helpers\StringHelper;
use common\widgets\echarts\assets\AppAsset;
use Yii;

/**
 * Class Echarts
 * @package common\widgets\echarts
 * @author funson86 <funson86@gmail.com>
 */
class Echarts extends \yii\base\Widget
{
    /**
     * @var array
     */
    public $config = [];


    /**
     * 默认主题
     *
     * @var string
     */
    public $chart = 'line-bar';

    /**
     * 模板主题
     *
     * @var string
     */
    public $theme = 'fresh-cut';

    /**
     * 默认主题配置
     *
     * @var array
     */
    public $chartConfig = ['today', 'yesterday', 'thisWeek', 'last7Day', 'last30Day', 'last30Week', 'thisMonth', 'lastMonth', 'thisYear'];

    /**
     * 图表ID
     *
     * @var
     */
    protected $chartId;

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        $this->chartId = IdHelper::snowFlakeId();
        $this->config = ArrayHelper::merge([
            'server' => '',
            'height' => '500px',
            'defaultType' => 'thisWeek',
        ], $this->config);

        $this->chartConfig = ArrayHelper::filter($this->attributeLabels(), $this->chartConfig);
    }

    /**
     * @return string
     */
    public function run()
    {
        // 注册资源
        $this->registerClientScript();

        if (empty($this->chart)) {
            return false;
        }

        return $this->render($this->chart, [
            'chartId' => $this->chartId,
            'config' => $this->config,
            'theme' => $this->theme,
            'chartConfig' => $this->chartConfig,
        ]);
    }

    /**
     * 注册资源
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        AppAsset::register($view);

        if ($this->chart == 'bmap') {
            $view->registerJsFile('http://api.map.baidu.com/api?v=2.0&ak=' . Yii::$app->params['map_baidu_ak']);
        }
    }

    /**
     * 标签
     * @return string[]
     */
    protected function attributeLabels()
    {
        return [
            'today' => Yii::t('app', 'Today'),
            'yesterday' => Yii::t('app', 'Yesterday'),
            'last7Day' => Yii::t('app', 'Last7Day'),
            'last30Day' => Yii::t('app', 'Last30Day'),
            'last30Week' => Yii::t('app', 'Last30Week'),
            'thisWeek' => Yii::t('app', 'ThisWeek'),
            'thisMonth' => Yii::t('app', 'ThisMonth'),
            'lastMonth' => Yii::t('app', 'LastMonth'),
            'thisYear' => Yii::t('app', 'ThisYear'),
            'lastYear' => Yii::t('app', 'LastYear'),
            'custom' => Yii::t('app', 'Custom'),
        ];
    }
}