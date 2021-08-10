<?php
namespace common\components\base;

use common\components\mailer\SmtpMailer;
use common\job\base\MailJob;
use Yii;

/**
 * Class MailSystem
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class MailSystem extends \yii\base\Component
{
    public $queue = false;

    public $mailer;

    public function init()
    {
        parent::init();
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
            return Yii::$app->queue->push(new MailJob([
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
