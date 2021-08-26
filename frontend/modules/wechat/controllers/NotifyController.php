<?php

namespace frontend\modules\wechat\controllers;

use common\helpers\WechatHelper;
use common\traits\PayNotify;
use Yii;


/**
 * Default controller for the `wechat` module
 */
class NotifyController extends BaseController
{
    use PayNotify;

    public $optionalAuth = ['index', 'wechat'];

    public $enableCsrfValidation = false;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return 'notify';
    }

    public function actionWechat()
    {
        Yii::error(file_get_contents('php://input'));
        if ($this->wechat($this->store->settings)) {
            return WechatHelper::success();
        }

        return WechatHelper::error();
    }

    public function afterNotify($data = null, $type = null)
    {
        Yii::error($data);
        $this->writeLog($data, $type);

        // 根据数据库订单记录

        return true;
    }
}
