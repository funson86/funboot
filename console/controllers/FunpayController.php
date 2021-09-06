<?php

namespace console\controllers;

use common\models\pay\Payment;

/**
 * Class FunpayController
 * @package console\controllers
 * @author funson86 <funson86@gmail.com>
 */
class FunpayController extends BaseController
{
    public function actionIndex()
    {
        echo 'funpay';
    }

    public function actionOrderExpire()
    {
        Payment::updateAll(['status' => Payment::STATUS_EXPIRED], ['status' => Payment::STATUS_INACTIVE]);
    }
}
