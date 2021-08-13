<?php

namespace console\modules\chat\services;

use common\helpers\ArrayHelper;
use console\modules\chat\models\Log;
use GatewayWorker\Lib\Gateway;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Class Events
 * @package console\modules\chat\services
 * @author funson86 <funson86@gmail.com>
 */
class Events
{
    public static function onMessage($clientId, $message)
    {
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$clientId session:".json_encode($_SESSION)." onMessage:".$message."\n";

        $messageArr = json_decode($message, true);
        if (!$messageArr) {
            return;
        }

        switch ($messageArr['type']) {
            case 'pong':
                return;
            case 'login':
                return static::login($clientId, $messageArr);
            case 'say':
                return static::say($clientId, $messageArr);
            default:
                throw new NotFoundHttpException('Unexpected type');
        }
    }
    

    public static function onClose($clientId)
    {
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$clientId onClose:''\n";

        if (isset($_SESSION['room_id'])) {
            $roomId = $_SESSION['room_id'];
            $res = ['type' => 'logout', 'from_client_id' => $clientId, 'from_client_name' => $_SESSION['client_name'], 'time' => date('Y-m-d H:i:s')];
            Gateway::sendToGroup($roomId, json_encode($res));
        }
    }

    public static function login($clientId, $arr)
    {
        if (!isset($arr['room_id'])) {
            throw new NotFoundHttpException("\$message_data['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:" . json_encode($arr));
        }

        $roomId = $arr['room_id'];
        $clientName = htmlspecialchars($arr['client_name']);
        $_SESSION['room_id'] = $roomId;
        $_SESSION['client_name'] = $clientName;

        $clientNew = [
            'type' => $arr['type'],
            'client_id' => $clientId,
            'client_name' => $clientName,
            'time' => date('Y-m-d H:i:s')
        ];
        Gateway::sendToGroup($roomId, json_encode($clientNew));
        Gateway::joinGroup($clientId, $roomId);

        $clients = Gateway::getClientSessionsByGroup($roomId);
        $list = [];
        foreach ($clients as $cId => $item) {
            $list[$cId] = $item['client_name'];
        }
        $clientNew['client_list'] = $list;

        $logs = Log::find()->where(['room_id' => $roomId, 'to_client_id' => ''])
            ->select(['id', 'name as client_name', 'from_client_id as client_id', 'content', 'FROM_UNIXTIME(created_at, "%Y-%m-%d %H:%i:%S") as time'])
            ->orderBy(['created_at' => SORT_DESC])->limit(5)->asArray()->all();
        $clientNew['log_list'] = ArrayHelper::sortByField($logs);
        return Gateway::sendToCurrentClient(json_encode($clientNew));
    }

    public static function say($clientId, $arr)
    {
        if (!isset($_SESSION['room_id'])) {
            throw new NotFoundHttpException("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']}");
        }

        $roomId = $_SESSION['room_id'];
        $clientName = $_SESSION['client_name'];

        $content = nl2br(htmlspecialchars($arr['content']));
        $res = [
            'type' => $arr['type'],
            'from_client_id' => $clientId,
            'from_client_name' => $clientName,
            'to_client_id' => $arr['to_client_id'],
            'content' => $content,
            'time' => date('Y-m-d H:i:s'),
        ];

        $ret = true;
        if ($arr['to_client_id'] != 'all') {
            $res['content'] = "<b>对你说: </b>" . $content;
            Gateway::sendToClient($arr['to_client_id'], json_encode($res));

            $res['content'] = "<b>你对" . htmlspecialchars($arr['to_client_name']) . "说：" . $content;
            $ret = Gateway::sendToCurrentClient(json_encode($res));
        } else {
            $ret = Gateway::sendToGroup($roomId, json_encode($res));
        }

        $model = new Log();
        $model->room_id = $roomId;
        $model->from_client_id = $clientId;
        $model->to_client_id = $arr['to_client_id'] == 'all' ? '' : $arr['to_client_id'];
        $model->name = $clientName;
        $model->content = htmlspecialchars($arr['content']);
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            Yii::error($model->errors);
        }
        return $ret;
    }
}
