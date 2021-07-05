<?php
namespace common\job\base;

use common\job\BaseJob;
use Yii;

/**
 * Class MailJob
 * @author funson86 <funson86@gmail.com>
 */
class MailJob extends BaseJob
{
    public $to;
    public $subject;
    public $content;
    public $cc = [];
    public $from;

    public function execute($queue)
    {
        if (!parent::execute($queue)) {
            return false;
        }

        Yii::$app->mailSystem->send($this->to, $this->subject, $this->content, $this->cc, $this->from);
    }
}
