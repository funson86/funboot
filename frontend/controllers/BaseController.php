<?php

namespace frontend\controllers;

use common\helpers\IdHelper;
use yii\base\Model;
use common\models\Store;
use Yii;
use yii\helpers\Json;

/**
 * Class BaseController
 * @package frontend\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \common\components\controller\BaseController
{
    public function beforeAction($action)
    {
        // 前台强制为英文
        if (parent::beforeAction($action)) {
            Yii::$app->language = 'en';
        }
        return true;
    }

    /**
     * @param $model
     * @return array
     */
    protected function commonData($model)
    {
        $settings = $this->getSettings();

        $strClosed = 'Closed Today';
        $commonData = [];
        $i = date('w');
        $arrDay = Json::decode($settings['business_work_' . $i]);
        $dayStarted = $arrDay[0]['started'] ?? '';
        $dayEnded = $arrDay[0]['ended'] ?? '';
        $arrCollection = explode('-', $settings['business_collection_time_cost']);
        $arrDelivery = explode('-', $settings['business_delivery_time_cost']);
        $arrTakeaway = explode('-', $settings['business_takeaway_time_cost']);
        $arrEatIn = explode('-', $settings['business_eat_in_time_cost']);
        $collectTime = date('H:i', strtotime($dayStarted) + intval($arrCollection[0]) * 60);
        $deliveryTime = date('H:i', strtotime($dayStarted) + intval($arrDelivery[0]) * 60);
        $takeawayTime = date('H:i', strtotime($dayStarted) + intval($arrTakeaway[0]) * 60);
        $eatInTime = date('H:i', strtotime($dayStarted) + intval($arrEatIn[0]) * 60);
        $commonData['averageCollect'] = intval(intval($arrCollection[0]) + intval($arrCollection[1] ?? 0)) / 2 * 60;
        $commonData['averageDelivery'] = intval(intval($arrDelivery[0]) + intval($arrDelivery[1] ?? 0)) / 2 * 60;
        $commonData['averageTakeaway'] = intval(intval($arrTakeaway[0]) + intval($arrTakeaway[1] ?? 0)) / 2 * 60;
        $commonData['averageEatIn'] = intval(intval($arrEatIn[0]) + intval($arrEatIn[1] ?? 0)) / 2 * 60;

        if (!$settings['business_open'] || !$dayStarted || $dayStarted == $dayEnded) {
            $commonData['strOpen'] = $strClosed;
            $commonData['open'] = 0;
        } else if (strpos($dayStarted, '|') === false) {
            $commonData['strOpen'] = "Opening at " . $dayStarted . "~" . $dayEnded;
            $commonData['open'] = (strtotime($dayStarted) < time() && time() < strtotime($dayEnded)) ? 2 : 1;
        } else {
            $arrStart = explode('|', $dayStarted);
            $arrEnd = explode('|', $dayEnded);
            $commonData['strOpen'] = "Opening at " . $arrStart[0] . "~" . $arrEnd[0] . ' ' . $arrStart[1] . "~" . $arrEnd[1];

            $commonData['open'] = ((strtotime($arrStart[0]) < time() && time() < strtotime($arrEnd[0])) || (strtotime($arrStart[1]) < time() && time() < strtotime($arrEnd[1]))) ? 2 : 1;
        }

        $commonData['checkoutButton'] = 'Pre-order for later';
        $commonData['checkoutCss'] = 'inactive';
        if ($commonData['open'] == 2) {
            $commonData['strDelivery'] = $settings['business_collection_time_cost'] . ' mins';
            $commonData['strCollection'] = $settings['business_collection_time_cost'] . ' mins';
            $commonData['strTakeaway'] = $settings['business_takeaway_time_cost'] . ' mins';
            $commonData['strEatIn'] = $settings['business_eat_in_time_cost'] . ' mins';
            $commonData['checkoutButton'] = 'Checkout';
            $commonData['checkoutCss'] = 'active';
        } elseif ($commonData['open'] == 1) {
            $commonData['strDelivery'] = "Starts at " . $deliveryTime;
            $commonData['strCollection'] = "Starts at " . $collectTime;
            $commonData['strTakeaway'] = "Starts at " . $takeawayTime;
            $commonData['strEatIn'] = "Starts at " . $eatInTime;
            $commonData['checkoutCss'] = 'active';
        } else {
            $commonData['checkoutButton'] = $strClosed;
            $commonData['strDelivery'] = $strClosed;
            $commonData['strCollection'] = $strClosed;
            $commonData['strTakeaway'] = $strClosed;
            $commonData['strEatIn'] = $strClosed;
        }

        // checkout 中使用
        $i = date('w');
        $arrDay = Json::decode($settings['business_work_' . $i]);
        $dayStarted = $deliveryStarted = $arrDay[0]['started'] ?? '';
        $dayEnded = $deliveryEnded = $arrDay[0]['ended'] ?? '';
        $now = date('H:i');

        $listTableOrderTime = [];
        $listCollectTime = [];
        $listDeliveryTime = [];
        $start = time();
        $arrCollectionTimeCost = explode('|', $settings['business_collection_time_cost']);
        $arrDeliveryTimeCost = explode('|', $settings['business_delivery_time_cost']);
        if (strlen($settings['business_delivery_time_range']) > 5) {
            $deliveryTimeRange = $settings['business_delivery_time_range'];
            $arrDeliveryTimeRange = json_decode($deliveryTimeRange, true);
            $deliveryStarted = $arrDeliveryTimeRange[0]['started'] ?? $dayStarted;
            $deliveryEnded = $arrDeliveryTimeRange[0]['ended'] ?? $dayEnded;
            $arrDeliveryTimeCost[0] = 0;
        }
        if ($commonData['open'] == 2) {
            $listCollectTime[0] = $listDeliveryTime[0] = 'As soon as possible';
        }
        if (strpos($dayStarted, '|') === false) {
            $open = ($dayStarted < $now && $now < $dayStarted) ? true : false;
            $end = strtotime($dayEnded);

            if ($start < (strtotime($dayStarted))) {
                $start = strtotime($dayStarted) - 1;
            }
            for ($i = intval(($start + 600) / 600) * 600; $i < $end; $i += 600) { // 订座
                $listTableOrderTime[date('H:i', $i)] = date('H:i', $i);
            }
            $startCollection = intval(($start + 600 + (intval($arrCollectionTimeCost[0]) * 60)) / 600) * 600;
            for ($i = $startCollection; $i < $end; $i += 600) {
                $listCollectTime[date('H:i', $i)] = 'Collection at ' . date('H:i', $i);
            }

            $start = time();
            if ($start < (strtotime($deliveryStarted))) {
                $start = strtotime($deliveryStarted) - 1;
            }
            $startDelivery = intval(($start + 600 + (intval($arrDeliveryTimeCost[0]) * 60)) / 600) * 600;
            for ($i = $startDelivery; $i < strtotime($deliveryEnded); $i += 600) {
                $listDeliveryTime[date('H:i', $i)] = 'Delivery at ' . date('H:i', $i);
            }
        } else {
            $arrStart = explode('|', $dayStarted);
            $arrEnd = explode('|', $dayEnded);

            if ($start < strtotime($arrStart[1])) {
                if ($start < strtotime($arrStart[0])) {
                    $start = strtotime($arrStart[0]);
                }
                for ($i = intval(($start + 600) / 600) * 600; $i < strtotime($arrEnd[0]); $i += 600) { // 订座
                    $listTableOrderTime[date('H:i', $i)] = date('H:i', $i);
                }

                $startCollection = $start;
                $startCollection = intval(($startCollection + 600 + (intval($arrCollectionTimeCost[0]) * 60)) / 600) * 600;
                for ($i = $startCollection; $i < strtotime($arrEnd[0]); $i += 600) {
                    $listCollectTime[date('H:i', $i)] = 'Collection at ' . date('H:i', $i);
                }

                for ($i = intval((strtotime($arrStart[1]) + 600) / 600) * 600; $i < strtotime($arrEnd[1]); $i += 600) { // 订座
                    $listTableOrderTime[date('H:i', $i)] = date('H:i', $i);
                }
                $startCollection = strtotime($arrStart[1]);
                $startCollection = intval(($startCollection + 600 + (intval($arrCollectionTimeCost[0]) * 60)) / 600) * 600;
                for ($i = $startCollection; $i < strtotime($arrEnd[1]); $i += 600) {
                    $listCollectTime[date('H:i', $i)] = 'Collection at ' . date('H:i', $i);
                }

                $startDelivery = $start;
                $startDelivery = intval(($startDelivery + 600 + (intval($arrDeliveryTimeCost[0]) * 60)) / 600) * 600;
                for ($i = $startDelivery; $i < strtotime($arrEnd[0]); $i += 600) {
                    $listDeliveryTime[date('H:i', $i)] = 'Delivery at ' . date('H:i', $i);
                }

                $startDelivery = strtotime($arrStart[1]);
                $startDelivery = intval(($startDelivery + 600 + (intval($arrDeliveryTimeCost[0]) * 60)) / 600) * 600;
                for ($i = $startDelivery; $i < strtotime($arrEnd[1]); $i += 600) {
                    $listDeliveryTime[date('H:i', $i)] = 'Delivery at ' . date('H:i', $i);
                }
            } elseif ($start < strtotime($arrEnd[1])) { //结束时间
                if (strtotime($arrEnd[0]) < $start && $start < (strtotime($arrStart[1]))) {
                    $startCollection = strtotime($arrStart[1]);
                }
                for ($i = intval(($startCollection + 600) / 600) * 600; $i < strtotime($arrEnd[1]); $i += 600) { // 订座
                    $listTableOrderTime[date('H:i', $i)] = date('H:i', $i);
                }

                $startCollection = intval($startCollection + 600 + (intval($arrCollectionTimeCost[0]) * 60)) / 600 * 600;
                for ($i = $startCollection; $i < strtotime($arrEnd[1]); $i += 600) {
                    $listCollectTime[date('H:i', $i)] = 'Delivery at ' . date('H:i', $i);
                }

                if (strtotime($arrEnd[0]) < $start && $start < (strtotime($arrStart[1]))) {
                    $startDelivery = strtotime($arrStart[1]);
                }
                $startDelivery = intval($startDelivery + 600 + (intval($arrDeliveryTimeCost[0]) * 60)) / 600 * 600;
                for ($i = $startDelivery; $i < strtotime($arrEnd[1]); $i += 600) {
                    $listDeliveryTime[date('H:i', $i)] = 'Delivery at ' . date('H:i', $i);
                }
            }
        }

        $commonData['listTableOrderTime'] = $listTableOrderTime;
        $commonData['listDeliveryTime'] = $listDeliveryTime;
        $commonData['listCollectTime'] = $listCollectTime;

        return $commonData;
    }
}
