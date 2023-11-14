<?php

namespace api\modules\v21\models;

use common\models\Store;
use Yii;

/**
 * Class User
 * @package api\models\food
 * @author funson86 <funson86@gmail.com>
 */
class User extends \api\models\User
{
    public function fields()
    {
        return [
            'id', 'access_token', 'refresh_token', 'username', 'email', 'store', 'avatar', 'balance',
            'paymentCurrency', 'paymentCurrency_', 'paymentCurrencyCode_',
        ];
    }

    /**
     * 指定extraFields中显示哪些字段
     * @return \stdClass|\yii\db\ActiveQuery|null
     */
    public function getStore()
    {
        return parent::getStore() ? parent::getStore()->select(['id', 'name', 'host_name', 'expired_at']) : new \stdClass();
    }


    public function getPaymentCurrency()
    {
        return Yii::$app->settingSystem->getValue('payment_currency', $this->store_id) ?? '$';
    }

    public function getPaymentCurrency_()
    {
        return Store::getCurrencyPrinterLabels(Yii::$app->settingSystem->getValue('payment_currency', $this->store_id) ?? '$');
    }

}
