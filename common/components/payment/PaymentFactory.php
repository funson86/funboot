<?php

namespace common\components\payment;

/**
 * Class PrinterFactory
 * @package common\components\food\printer
 * @author funson86 <funson86@gmail.com>
 */
class PaymentFactory
{
    /**
     * @param $class
     * @return BasePayment
     */
    public static function factory($class, $config) {
        $class = __NAMESPACE__ . '\\' . $class;
        /** @var BasePayment $instance */
        $instance = new $class;
        $instance->initConfig($config);
        return $instance;
    }
}
