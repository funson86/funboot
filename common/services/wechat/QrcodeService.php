<?php

namespace common\services\wechat;

use common\helpers\ArrayHelper;
use common\models\wechat\Fan;
use common\models\wechat\Qrcode;
use Yii;

/**
 * Class QrcodeService
 * @package common\services\wechat
 * @author funson86 <funson86@gmail.com>
 */
class QrcodeService
{

    public static function create($type, $sceneStr, $model = null, $options = [])
    {
        if (!$model) {
            $model = new Qrcode();
            $model->name = $options['name'] ?? $sceneStr;
            $model->keyword = $options['keyword'] ?? '';
        }

        $type == Qrcode::TYPE_TEMP && !$model->expired_second && $model->expired_second = $options['expired_second'] ?? 0;
        if (0 < intval($sceneStr) && intval($sceneStr) < Qrcode::SCENE_MAX_VALUE) {
            $model->scene_id = intval($sceneStr);
            $model->scene_str = '';
        } else {
            $model->scene_id = 0;
            $model->scene_str = (string)$sceneStr;
        }

        $type == Qrcode::TYPE_PERM && $result = Yii::$app->wechat->app->qrcode->forever($model->scene_id ?? $model->scene_str);
        $type == Qrcode::TYPE_TEMP && $result = Yii::$app->wechat->app->qrcode->temporary($model->scene_id ?? $model->scene_str, $model->expired_second);

        $model->type = $type;
        $model->ticket = $result['ticket'];
        $model->type == Qrcode::TYPE_TEMP && $model->expired_second = intval($result['expire_seconds']);
        $model->type == Qrcode::TYPE_TEMP && $model->expired_second > 0 && $model->expired_at = time() + $model->expired_second;

        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return false;
        }

        return true;

    }

    public static function url($ticket)
    {
        return Yii::$app->wechat->app->qrcode->url($ticket);
    }
}
