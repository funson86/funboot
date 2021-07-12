<?php

namespace common\components\mailer;

use common\helpers\ValidHelper;
use Yii;

/**
 * Class MailHelper
 *
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class SmtpMailer
{
    public $config = [];

    public function __construct($config = [])
    {
        $this->config = $config;
        if (count($config) > 0) {
            $this->setConfig($config);
        } else {
            if (isset(Yii::$app->params['smtpHosts']) && count(Yii::$app->params['smtpHosts']) > 0) {
                $count = count(Yii::$app->params['smtpHosts']);
                $i = rand(0, $count - 1);
                $this->setConfig([
                    'host' => Yii::$app->params['smtpHosts'][$i]['smtp_host'] ?? Yii::$app->params['smtp_host'],
                    'username' => Yii::$app->params['smtpHosts'][$i]['smtp_username'] ?? Yii::$app->params['smtp_username'],
                    'password' => Yii::$app->params['smtpHosts'][$i]['smtp_password'] ?? Yii::$app->params['smtp_password'],
                    'port' => Yii::$app->params['smtpHosts'][$i]['smtp_port'] ?? Yii::$app->params['smtp_port'],
                    'encryption' => Yii::$app->params['smtpHosts'][$i]['smtp_encryption'] ?? Yii::$app->params['smtp_encryption'],
                ]);
            } else {
                $this->setConfig([
                    'host' => Yii::$app->params['smtp_host'],
                    'username' => Yii::$app->params['smtp_username'],
                    'password' => Yii::$app->params['smtp_password'],
                    'port' => Yii::$app->params['smtp_port'],
                    'encryption' => Yii::$app->params['smtp_encryption'],
                ]);
            }
        }
    }


    /**
     * 配置
     *
     * eg: $config = [
     * 'host'       => Yii::$app->params['smtp_host'],
     * 'username'   => Yii::$app->params['smtp_username'],
     * 'password'   => Yii::$app->params['smtp_password'],
     * 'port'       => Yii::$app->params['smtp_port'],
     * 'encryption' => Yii::$app->params['smtp_encryption'],
     * @param array $config 配置 包括host  username password port encryption
     * @return bool
     * @throws \Exception
     */
    public function setConfig($config = [])
    {
        $this->config = $config;
        Yii::$app->mailer->useFileTransport = false;
        Yii::$app->mailer->setTransport([
            'class'      => 'Swift_SmtpTransport',
            'host'       => $this->config['host'],
            'username'   => $this->config['username'],
            'password'   => $this->config['password'],
            'port'       => $this->config['port'],
            'encryption' => $this->config['encryption'],
        ]);
    }

    /**
     * 发送邮件
     *
     * @param string $to 发送目标邮件地址
     * @param string $from 发送源邮件地址
     * @param string $subject
     * @param string $content
     * @param array $cc 抄送
     * @return bool
     * @throws \Exception
     */
    public function send($to, $subject, $content, $cc = [], $from = null)
    {
        if (!ValidHelper::isEmail($to)) {
            Yii::error('Invalid mail: ' . $to . ' ' . $from);
            return false;
        }

        try {
            $mailer = Yii::$app->mailer->compose();
            if ($from) {
                $mailer->setFrom($from);
            } else {
                $mailer->setFrom($this->config['username']);
            }
            $mailer->setTo($to);
            $mailer->setSubject($subject);
            $mailer->setHtmlBody($content);
            if ($cc && count($cc) > 0) {
                $mailer->setCc($cc);
            }

            $result = $mailer->send();
            Yii::info($result);
            return $result;
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
        }
    }
}