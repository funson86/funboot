<?php
namespace common\widgets\multipleinput;

use Yii;
use common\helpers\ArrayHelper;
use yii\base\Model;

/**
 * 增加多语言，使用setting.php作为翻译语言
 * Class MultipleInput
 * @package common\widgets\multipleinput
 * @author funson86 <funson86@gmail.com>
 */
class MultipleInput extends \unclead\multipleinput\MultipleInput
{

    /**
     * Initializes data.
     */
    protected function initData()
    {
        if ($this->data !== null) {
            return;
        }

        if ($this->value !== null) {
            $this->data = $this->value;
            return;
        }

        if ($this->model instanceof Model) {
            $data = ($this->model->hasProperty($this->attribute) || isset($this->model->{$this->attribute}))
                ? ArrayHelper::getValue($this->model, $this->attribute, [])
                : [];

            if (!is_array($data) && empty($data)) {
                return;
            }

            if (!($data instanceof \Traversable)) {
                $data = (array) $data;
            }

            foreach ($data as $index => $value) {
                $this->data[$index] = Yii::t('setting', $value);
            }
        }
    }

}
