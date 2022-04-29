<?php

namespace backend\modules\base\controllers;

use common\components\base\LogSystem;
use common\components\enums\Status;
use common\helpers\EchartsHelper;
use Yii;
use common\models\base\Log;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\data\Pagination;

/**
* Log
*
* Class LogController
* @package backend\modules\base\controllers
*/
class LogController extends BaseController
{
    /**
    * @var Log
    */
    public $modelClass = Log::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name', 'url', 'ip', 'msg'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $editAjaxFields = ['name', 'sort'];

    /**
     * 导入导出字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'name' => 'text',
        'type' => 'select',
    ];

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->logSystem->driver == LogSystem::DRIVER_MONGODB) {
                $this->modelClass = \common\models\mongodb\Log::class;
            }
            return true;
        }
    }

    /**
     * 列表页
     * @param int $type
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        if (Yii::$app->logSystem->driver == LogSystem::DRIVER_MONGODB) {
            $query = $this->modelClass::find()->where(['type' => intval($type)]);
            $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => $this->pageSize]);
            $models = $query->orderBy(['id' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();

            return $this->render($this->action->id, [
                'models' => $models,
                'pages' => $pagination,
            ]);
        }

        return parent::actionIndex();
    }

    protected function filterParams(&$params)
    {
        $params['ModelSearch']['type'] = Yii::$app->request->get('type', 1);
    }

    /**
     * 错误统计
     * @param string $type
     * @return array|mixed
     */
    public function actionViewAjaxStatError()
    {
        $type = Yii::$app->request->get('type');

        // 返回Modal视图
        if (empty($type)) {
            return $this->renderAjax($this->action->id);
        }

        // 返回json数据
        $fields = [];
        $codes = [400, 401, 403, 405, 422, 429, 500];
        foreach ($codes as $code) {
            $fields[$code] = $code . Yii::t('app', 'Error');
        }

        // 获取时间和格式化
        list($time, $format) = EchartsHelper::getFormatTime($type);

        $data = $this->getEchartStat($this->modelClass::TYPE_ERROR, $codes, $fields, $time, $format);
        return $this->success($data);
    }

    /**
     * 错误统计
     * @param string $type
     * @return array|mixed
     */
    public function actionViewAjaxStatLogin()
    {
        $type = Yii::$app->request->get('type');

        // 返回Modal视图
        if (empty($type)) {
            return $this->renderAjax($this->action->id);
        }

        // 返回json数据
        $fields = [];
        $codes = [200, 599];
        foreach ($codes as $code) {
            $fields[$code] = Log::getCodeLabels($code);
        }

        // 获取时间和格式化
        list($time, $format) = EchartsHelper::getFormatTime($type);

        $data = $this->getEchartStat($this->modelClass::TYPE_LOGIN, $codes, $fields, $time, $format);
        return $this->success($data);
    }

    protected function getEchartStat($type, $codes, $fields, $time, $format)
    {
        // 获取数据
        $data = EchartsHelper::lineOrBarInTime(function ($startTime, $endTime, $formatting) use ($type, $codes) {
            $statData = $this->modelClass::find()
                ->select(["from_unixtime(created_at, '$formatting') as time", 'count(*) as count', 'code'])
                ->andWhere(['between', 'created_at', $startTime, $endTime])
                ->andWhere(['type' => $type])
                ->andWhere(['in', 'code', $codes])
                ->groupBy(['time', 'code'])
                ->asArray()
                ->all();

            return EchartsHelper::regroupTimeData($statData, 'code');
        }, $fields, $time, $format);

        return $data;
    }
}
