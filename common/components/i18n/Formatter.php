<?php

namespace common\components\i18n;

use yii\helpers\Html;

/**
 * Class Formatter
 * @package common\components\i18n
 * @author funson86 <funson86@gmail.com>
 */
class Formatter extends \yii\i18n\Formatter
{

    /**
     * Formats the value as is without any formatting.
     * This method simply returns back the parameter without any format.
     * The only exception is a `null` value which will be formatted using [[nullDisplay]].
     * @param mixed $value the value to be formatted.
     * @return string the formatted result.
     */
    public function asJson($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        return is_array($value) ? Html::encode(json_encode($value)) : $value;
    }

}