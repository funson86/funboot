<?php

namespace common\components\enums;

use Yii;

/**
 * Class YesNo
 * @package common\components\enums
 * @author funson86 <funson86@gmail.com>
 */
class YesNo
{
    const YES = 1;
    const NO = 0;

    /**
     * return label or labels array
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::YES => Yii::t('cons', 'YES'),
            self::NO => Yii::t('cons', 'NO'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        if (!is_null($id)) {
            return $data[$id] ?? $id;
        }
        return $data;
    }
}
