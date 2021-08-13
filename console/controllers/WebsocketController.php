<?php

namespace console\controllers;

use Workerman\Worker;
use yii\console\Controller;

/**
 * Class Websocket
 * @package console\controllers
 * @author funson86 <funson86@gmail.com>
 */
class WebsocketController extends Controller
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

    protected function initWorker()
    {
        $wsWorker = new Worker("websocket://0.0.0.0:2000");
        $wsWorker->count = 4;
        $wsWorker->onMessage = function($connection, $data)
        {
            // 向客户端发送hello $data
            $connection->send('hello ' . $data);
        };
    }

    public function actionIndex()
    {
        $this->initWorker();
        Worker::runAll();
    }
}
