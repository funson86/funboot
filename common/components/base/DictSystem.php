<?php

namespace common\components\base;

use common\helpers\ArrayHelper;
use common\models\base\DictData;
use Yii;
use common\models\base\Dict;

/**
 * Class DictSystem
 * @package common\components\base
 * @author funson86 <funson86@gmail.com>
 */
class DictSystem extends \yii\base\Component
{
    public $allDict;

    public $mapCodeDict;

    public $allDictData;

    public $mapCodeDictData;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->allDict = Yii::$app->cacheSystem->getAllDict();
        $this->mapCodeDict = ArrayHelper::mapIdData($this->allDict, 'code');

        $this->allDictData = Yii::$app->cacheSystem->getAllDictData();
        $this->mapCodeDictData = ArrayHelper::mapIdData($this->allDictData, 'code');
    }

    /**
     * 返回字典项
     * @param $key
     * @param bool $kv 是否返回 key => value 方式
     * @return array|mixed|string
     */
    public function getDict($key, $kv = true)
    {
        if ($kv && isset($this->mapCodeDict[$key]['dictDatas'])) {
            return ArrayHelper::map($this->mapCodeDict[$key]['dictDatas'], 'code', 'value');
        }

        return $this->mapCodeDict[$key] ?? '';
    }

    /**
     * 返回字典值
     * @param $key
     * @param bool $kv 是否返回 key => value 方式
     * @return mixed|string
     */
    public function getData($key, $kv = true)
    {
        if ($kv && isset($this->mapCodeDictData[$key]['value'])) {
            return $this->mapCodeDictData[$key]['value'] ?? '';
        }

        return $this->mapCodeDictData[$key] ?? '';
    }

    /**
     * 清除cache
     * @return bool
     */
    public function clearCache()
    {
        return Yii::$app->cacheSystem->clearAllDict() && Yii::$app->cacheSystem->clearAllDictData();
    }
}