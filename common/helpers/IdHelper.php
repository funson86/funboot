<?php

namespace common\helpers;

use Godruoyi\Snowflake\LaravelSequenceResolver;
use Godruoyi\Snowflake\RandomSequenceResolver;
use Godruoyi\Snowflake\RedisSequenceResolver;
use Godruoyi\Snowflake\SequenceResolver;
use Godruoyi\Snowflake\Snowflake;
use Ramsey\Uuid\Uuid;
use Redis;
use Yii;

/**
 * Class IdHelper
 * @package common\helpers
 * @author funson86 <funson86@gmail.com>
 */
class IdHelper
{
    /**
     * https://github.com/godruoyi/php-snowflake
     * @param int $dataCenterId
     * @param int $workerId
     * @param int $startAt
     * @return string
     * @throws \Exception
     */
    public static function snowFlakeId($dataCenterId = 0, $workerId = 0, $startAt = 0)
    {
        try {
            if ($dataCenterId == 0) {
                $dataCenterId = Yii::$app->params['snowFlakeDataCenterId'] ?? 0;
            }
            if ($workerId == 0) {
                $workerId = Yii::$app->params['snowFlakeWorkerId'] ?? 0;
            }

            $snowflake = new Snowflake($dataCenterId, $workerId);

            // 计算开始时间
            $snowFlakeStartAt = isset(Yii::$app->params['snowFlakeStartAt']) && Yii::$app->params['snowFlakeStartAt'] ? strtotime(Yii::$app->params['snowFlakeStartAt']) : 0;
            $startAt = $startAt > 0 ? $startAt : $snowFlakeStartAt;
            if ($startAt > 0) {
                $snowflake->setStartTimeStamp($startAt);
            }

            // 如果配置需要真正唯一ID，通过redis自增方式实现
            $snowFlakeUniqueId = Yii::$app->params['snowFlakeUniqueId'] ?? false;
            if ($snowFlakeUniqueId && class_exists('Redis')) {
                $redis = new Redis();
                $host = Yii::$app->params['snowFlakeRedis']['host'] ?? '127.0.0.1';
                $port = Yii::$app->params['snowFlakeRedis']['port'] ?? '6379';
                $redis->connect($host, $port);
                $snowflake->setSequenceResolver(new RedisSequenceResolver($redis));
            }

            return $snowflake->id();
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
        }
    }

    //https://github.com/ramsey/uuid
    public static function uuid($version = 4, $name = null)
    {
        !$name && $name = rand(10000, 99999);
        if ($version == 1) {
            return Uuid::uuid1()->toString();
        } elseif ($version == 3) {
            return Uuid::uuid3(Uuid::NAMESPACE_DNS, (string)$name)->toString();
        } elseif ($version == 5) {
            return Uuid::uuid5(Uuid::NAMESPACE_DNS, (string)$name)->toString();
        }

        return Uuid::uuid4()->toString();
    }
}