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

    /**
     * 微信支付回调
     * @return bool|string
     */
    public function actionWechat()
    {
        Yii::error(file_get_contents('php://input'));
        if ($this->wechat($this->store->settings)) {
            return WechatHelper::success();
        }

        return WechatHelper::error();
    }

    /**
     * 支付宝回调
     * @return string
     */
    public function actionAlipay()
    {
        if ($this->alipay($this->store->settings)) {
            return 'success';
        }

        return 'fail';
    }

    public function afterNotify($data = null, $type = null)
    {
        Yii::error($data);
        $this->writeLog($data, $type);

        // 根据数据库订单记录

        /*
         *
         * wehcat
         * [
         *     'appid' => 'wx85d219c4f262dbe4',
         *     'bank_type' => 'CMB_CREDIT',
         *     'cash_fee' => '1',
         *     'fee_type' => 'CNY',
         *     'is_subscribe' => 'Y',
         *     'mch_id' => '1522368541',
         *     'nonce_str' => '612627913cba9',
         *     'openid' => 'oGNvK5rH59h4DD2w2rit9Y5AoYRo',
         *     'out_trade_no' => '162989044927123541',
         *     'result_code' => 'SUCCESS',
         *     'return_code' => 'SUCCESS',
         *     'sign' => 'B5D812E9ECC9EEACFC4348A755C0B645',
         *     'time_end' => '20210825192056',
         *     'total_fee' => '1',
         *     'trade_type' => 'JSAPI',
         *     'transaction_id' => '4200001130202108251929622990',
         * ]
         */
        if ($type == 'wechat') {
            // $data['cash_fee'] $data['out_trade_no'] $data['mch_id']
            //根据返回值更新订单

        } elseif ($type == 'alipay') {
            // $data['total_amount'] $data['trade_no'] $data['auth_app_id']
        }

        return true;
    }
}
