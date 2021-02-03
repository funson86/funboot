<?php

namespace common\services\wechat;

use common\helpers\ArrayHelper;
use common\models\wechat\Fan;
use common\models\wechat\Tag;
use Yii;

/**
 * Class TagService
 * @package common\services\wechat
 * @author funson86 <funson86@gmail.com>
 */
class TagService
{
    public static function syncAll()
    {
        $tags = Yii::$app->wechat->app->user_tag->list();

        $model = Tag::find()->where(['store_id' => Yii::$app->storeSystem->getId()])->one();
        if (!$model) {
            $model = new Tag;
        }
        $model->tags = $tags['tags'] ?? [];
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return false;
        }

        return true;
    }

}
