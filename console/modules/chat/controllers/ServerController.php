<?php

namespace console\modules\chat\controllers;

use console\modules\chat\services\Events;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Workerman\Worker;
use yii\console\Controller;
use Yii;

/**
 * Class ServerController
 * @package console\modules\chat\controllers
 * @author funson86 <funson86@gmail.com>
 */
class ServerController extends Controller
{
    public $commands = [
        'start',
        'stop',
        'restart',
        'reload',
        'status',
        'connections',
    ];
    public $command = 'start';
    public $daemon;
    public $gracefully;
    public $query; // windows下查询状态

    public function options($actionID)
    {
        return ['daemon', 'gracefully', 'query'];
    }

    public function optionAliases()
    {
        return [
            'd' => 'daemon',
            'g' => 'gracefully',
            'q' => 'query',
        ];
    }

    public function init()
    {
        global $argv;
        foreach ($argv as $value) {
            in_array($value, $this->commands) && $this->command = $value;
        }
    }

    // linux 下直接执行 php yii chat/websocket
    public function actionIndex()
    {
        $this->actionRegister(true);
        $this->actionGateway(true);
        $this->actionBusinessworker(true);

        Worker::runAll();
    }

    public function actionGateway($global = false)
    {
        $gateway = new Gateway("Websocket://" . (Yii::$app->params['chat']['gateway']['server'] ?? '0.0.0.0') . ":" . (Yii::$app->params['chat']['gateway']['port'] ?? '7272') . ")");
        // 设置名称，方便status时查看
        $gateway->name = 'ChatGateway';
        // 设置进程数，gateway进程数建议与cpu核数相同
        $gateway->count = Yii::$app->params['chat']['gateway']['count'] ?? 4;
        // 分布式部署时请设置成内网ip（非127.0.0.1）
        $gateway->lanIp = Yii::$app->params['chat']['gateway']['lanIp'] ?? '127.0.0.1';
        // 内部通讯起始端口。假如$gateway->count=4，起始端口为2300
        // 则一般会使用2300 2301 2302 2303 4个端口作为内部通讯端口
        $gateway->startPort = 2300;
        // 心跳间隔
        $gateway->pingInterval = 10;
        // 心跳数据
        $gateway->pingData = '{"type":"ping"}';
        // 服务注册地址
        $gateway->registerAddress = (Yii::$app->params['chat']['register']['server'] ?? '127.0.0.1') . ':' . (Yii::$app->params['chat']['register']['port'] ?? '1236');

        if (!$global) {
            Worker::runAll();
        }
    }

    public function actionBusinessworker($global = false)
    {
        $worker = new BusinessWorker();
        // worker名称
        $worker->name = 'ChatBusinessWorker';
        // bussinessWorker进程数量
        $worker->count = Yii::$app->params['chat']['businessworker']['count'] ?? 4;
        // 服务注册地址
        $worker->registerAddress = (Yii::$app->params['chat']['register']['server'] ?? '127.0.0.1') . ':' . (Yii::$app->params['chat']['register']['port'] ?? '1236');

        // 事件处理函数，需要实现onMessage onClose函数
        $worker->eventHandler = Events::class;

        if (!$global) {
            Worker::runAll();
        }
    }

    public function actionRegister($global = false)
    {
        $register = new Register('text://' . (Yii::$app->params['chat']['register']['server'] ?? '127.0.0.1') . ':' . (Yii::$app->params['chat']['register']['port'] ?? '1236'));

        if (!$global) {
            Worker::runAll();
        }
    }
}
