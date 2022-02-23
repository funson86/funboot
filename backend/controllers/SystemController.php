<?php

namespace backend\controllers;

use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\helpers\Url;
use Probe\Provider\AbstractProvider;
use Probe\ProviderFactory;
use Yii;
use common\models\base\Message;
use common\models\ModelSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\components\controller\BaseController;

/**
 * System
 *
 * Class MessageController
 * @package backend\controllers
 */
class SystemController extends BaseController
{
    const CACHE_SYSTEM_INFO = 'system:info';

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name'];

    /**
     * @var int
     */
    public $pageSize = 20;

    /**
     * 行为控制
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = 'main';
        parent::beforeAction($action);
        return true;
    }

    /**
      * 列表页
      * @return string
      * @throws \yii\web\NotFoundHttpException
      */
    public function actionIndex()
    {
        $type = Yii::$app->request->get('type', '');
        $provider = ProviderFactory::create();
        if (!$provider) {
            return $this->htmlFailed();
        }

        if (Yii::$app->request->isAjax) {
            $model = $this->getModel($provider, true);
            return $this->success($model);
        }

        $model = $this->getModel($provider);
        return $this->render($this->action->id . ($type ? '-' . $type : ''), [
            'model' => $model,
        ]);
    }

    /**
     * @param AbstractProvider $provider
     * @return array
     */
    protected function getModel(AbstractProvider $provider, $ajax = false)
    {
        $cpuUsage = $provider->getCpuUsage();
        $model = [
            'cpu' => [
                'cpuUsage' => array_pop($cpuUsage),
            ],
            'memory' => [
                'totalMem' => round($provider->getTotalMem() / (1024 * 1024), 2),
                'freeMem' => round($provider->getFreeMem() / (1024 * 1024), 2),
                'usedMem' => round($provider->getUsedMem() / (1024 * 1024), 2),
                'memUsage' => round($provider->getUsedMem() / $provider->getTotalMem(), 2),
                'totalSwap' => round($provider->getTotalSwap() / 1024 * 1024, 2),
                'freeSwap' => round($provider->getFreeSwap() / (1024 * 1024), 2),
                'usedSwap' => round($provider->getUsedSwap() / (1024 * 1024), 2),
                'swapUsage' => round($provider->getUsedSwap() / $provider->getTotalSwap(), 2),
            ],
            'uptime' => $provider->getUptime(),
            'loadavg' => $this->getLoadavg(),
            'net' => $this->getNet(),
            'now' => time(),
        ];

        if (!$ajax) {
            $model = ArrayHelper::merge($model, [
                'environment' => $this->getEnvironment(),
                'disk' => $this->getDisk(),
                'cpu' => [
                    'cpuModel' => $provider->getCpuModel(),
                    'cpuCores' => $provider->getCpuCores(),
                    'cpuVendor' => $provider->getCpuVendor(),
                    'cpuPhysicalCores' => $provider->getCpuPhysicalCores(),
                ],
            ]);
        }


        $num = 5;
        $numArr = [];
        for ($i = 30; $i >= 1; $i--) {
            $numArr[] = date('H:i:s', time() - $i * $num);
        }

        $model['chartTime'] = $numArr;

        return $model;
    }

    /**
     * 服务器信息
     * @return mixed
     */
    protected function getEnvironment()
    {
        $arr['ip'] = @$_SERVER['REMOTE_ADDR'];
        $domain = $this->linux() ? $_SERVER['SERVER_ADDR'] : @gethostbyname($_SERVER['SERVER_NAME']);
        $os = explode(" ", php_uname());
        $arr['domainIP'] = @get_current_user() . ' - ' . $_SERVER['SERVER_NAME'] . '(' . $domain . ')';
        $arr['flag'] = php_uname();
        $arr['phpOs'] = PHP_OS;
        $arr['os'] = $os[0] . Yii::t('system', ' Kernel: ') . ($this->linux() ? $os[2] : $os[1]);
        $arr['language'] = @$_SERVER['HTTP_ACCEPT_LANGUAGE'];;
        $arr['name'] = $this->linux() ? $os[1] : $os[2];
        $arr['email'] = @$_SERVER['SERVER_ADMIN'];
        $arr['serverEngine'] = $_SERVER['SERVER_SOFTWARE'];
        $arr['serverPort'] = @$_SERVER['SERVER_PORT'];
        $arr['webPath'] = $_SERVER['DOCUMENT_ROOT'] ? str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) : str_replace('\\', '/', dirname(__FILE__));
        $arr['scriptPath'] = str_replace('\\', '/', __FILE__) ? str_replace('\\', '/', __FILE__) : $_SERVER['SCRIPT_FILENAME'];
        $arr['now'] = date('Y-m-d H:i:s');

        return $arr;
    }

    /**
     * 硬盘信息
     * @return mixed
     */
    public function getDisk()
    {
        $arr['total'] = round(@disk_total_space(".") / (1024 * 1024 * 1024), 2);
        $arr['free'] = round(@disk_free_space(".") / (1024 * 1024 * 1024), 2);
        $arr['used'] = round($arr['total'] - $arr['free'], 2);
        $usage_rate = (floatval($arr['total']) != 0) ? round($arr['used'] / $arr['total'] * 100, 2) : 0;
        $arr['usage_rate'] = round($usage_rate, 2);

        return $arr;
    }

    /**
     * 获取系统负载
     * @return array
     */
    protected function getLoadavg()
    {
        $arr = ['loadavg' => 0, 'desc' => ''];
        if (!$this->linux()) {
            return $arr;
        }

        if ($loadavg = @file("/proc/loadavg")) {
            $loadavg = explode(" ", implode("", $loadavg));
            $loadavg = array_chunk($loadavg, 4);
            $arr['loadavg'] = $loadavg;
            $arr['explain'] = implode(" ", $loadavg[0]);
        }

        return $arr;
    }

    /**
     * 网络信息
     * @return array
     */
    public function getNet()
    {
        $arr = ['allOutputSpeed' => 0, 'allInputSpeed' => 0, 'currentOutputSpeed' => 0, 'currentInputSpeed' => 0];
        if (!$this->linux()) {
            return $arr;
        }

        $strs = @file("/proc/net/dev");
        $lines = count($strs);
        for ($i = 2; $i < $lines; $i++) {
            preg_match_all("/([^\s]+):[\s]{0,}(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $strs[$i], $info);

            $name = $info[1][0];
            $arr[$name]['name'] = $name;
            $arr[$name]['outputSpeed'] = $info[10][0];
            $arr[$name]['inputSpeed'] = $info[2][0];

            $arr['allOutputSpeed'] += $info[10][0];
            $arr['allInputSpeed'] += $info[2][0];
        }

        return $arr;
    }

    /**
     * 判断linux系统还是windows系统
     *
     * @return bool
     */
    private function linux()
    {
        return DIRECTORY_SEPARATOR == '/' ? true : false;
    }
}
