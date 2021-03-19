<?php

namespace common\services\wechat;

use common\components\enums\YesNo;
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
    public static function syncAll($nextOpenid = null)
    {
        $fans = Yii::$app->wechat->app->user->list($nextOpenid);
        $count = $fans['total'];
        $pages = ceil($count / 500);
        for ($i = 0; $i < $pages; $i++) {
            $openids = array_slice($fans['data']['openid'], $i * 500, 500);
            $fanList = Fan::find()->where(['store_id' => Yii::$app->storeSystem->getId(), 'openid' => $openids])->select('openid')->asArray()->all();
            $existOpenids = ArrayHelper::getColumn($fanList, 'openid');

            $field = ['store_id', 'openid', 'subscribe', 'created_at', 'updated_at', 'created_by', 'updated_by'];
            $newFans = [];
            foreach ($openids as $openid) {
                if (!in_array($openid, $existOpenids)) {
                    $newFans[] = [Yii::$app->storeSystem->getId(), $openid, YesNo::YES, time(), time(), Yii::$app->user->id, Yii::$app->user->id];
                }
            }

            if (!empty($newFans)) {
                Yii::$app->db->createCommand()->batchInsert(Fan::tableName(), $field, $newFans)->execute();
            }

            Fan::updateAll(['subscribe' => YesNo::YES], ['openid' => $openids]);
        }

        return ['total' => $fans['total'], 'count' => $fans['count'], 'nextOpenid' => $fans['next_openid']];
    }

    /**
     * @param $openids
     * @return null
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public static function syncSelect($openids)
    {
        if (empty($openids)) {
            return null;
        }

        foreach ($openids as $openid) {
            self::syncInfo($openid);
        }

        return true;
    }

    /**
     * @param $openid
     * @return null
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public static function syncInfo($openid)
    {
        if (!$openid) {
            return null;
        }

        $result = Yii::$app->wechat->app->user->get($openid);
        $user = ArrayHelper::toArray($result);
        $model = self::findModelByOpenid($openid);
        $model->attributes = $user;
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return false;
        }

        return true;
    }


    public static function findModelByOpenid($openid)
    {
        if (empty($openid) || empty(($model = Fan::find()->where(['openid' => $openid])->andFilterWhere(['store_id' => Yii::$app->storeSystem->getId()])->one()))) {
            return new Fan();
        }

        return $model;

    }

}
