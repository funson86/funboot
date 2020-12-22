<?php
namespace common\components\base;

use common\components\mailer\SmtpMailer;
use common\helpers\CommonHelper;
use common\helpers\IdHelper;
use common\helpers\IpHelper;
use common\job\base\LogJob;
use common\job\base\MailJob;
use common\models\base\Log;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Request;
use yii\web\Response;
use yii\base\Exception;

/**
 * Class MailSystem
 * @author funson86 <funson86@gmail.com>
 *
 * @property-write mixed $config
 */
class MailSystem extends \yii\base\Component
{
    public $queue = false;

    public $mailer;

    public function __construct($config = [])
    {
        $this->mailer = new SmtpMailer();
    }

    public function setConfig($config)
    {
        return $this->mailer->setConfig($config);
    }

    public function send($to, $subject, $content, $cc = [], $from = null)
    {
        // 插入队列
        if ($this->queue) {
            Yii::$app->queue->push(new MailJob([
                'to' => $to,
                'subject' => $subject,
                'content' => $content,
                'cc' => $cc,
                'from' => $from,
            ]));
        } else {
            return $this->sendReal($to, $subject, $content, $cc, $from);
        }
    }

    public function sendReal($to, $subject, $content, $cc = [], $from = null)
    {
        $result = $this->mailer->send($to, $subject, $content, $cc, $from);

        $code = $result ? 200 : 500;
        Yii::$app->logSystem->mail($to, $subject, $content, $cc, $from, $code);

        return $result;
    }

}
