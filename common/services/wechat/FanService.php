<?php

namespace common\services\wechat;

use common\helpers\ArrayHelper;
use common\models\wechat\Fan;
use Yii;

/**
 * Class FanService
 * @package common\services\wechat
 * @author funson86 <funson86@gmail.com>
 */
class FanService
{
    /**
     * @param null $nextOpenid
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public static function refreshAll($nextOpenid = null)
    {
        $fans = Yii::$app->wechat->app->user->list($nextOpenid);
        foreach ($fans['data']['openid'] as $openid) {
            self::refreshInfo($openid);
        }

        return ['total' => $fans['total'], 'count' => $fans['count'], 'nextOpenid' => $fans['next_openid']];
    }

    /**
     * @param $openids
     * @return null
     */
    public static function refreshSelect($openids)
    {
        if (empty($openids)) {
            return null;
        }

        foreach ($openids as $openid) {
            self::refreshInfo($openid);
        }
    }

    /**
     * @param $openid
     * @return null
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public static function refreshInfo($openid)
    {
        if (!$openid) {
            return null;
        }

        $result = Yii::$app->wechat->app->user->get($openid);
        $user = ArrayHelper::toArray($result);
        $fan = self::findModelByOpenid($openid);
        $fan->attributes = $user;
        $fan->save();
    }


    public static function findModelByOpenid($openid)
    {
        if (empty($openid) || empty(($model = Fan::find()->where(['openid' => $openid])->andFilterWhere(['store_id' => Yii::$app->storeSystem->getId()])->one()))) {
            return new Fan();
        }

        return $model;

    }

}
