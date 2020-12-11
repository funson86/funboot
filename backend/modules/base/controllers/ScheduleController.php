<?php

namespace backend\modules\base\controllers;

use Yii;
use common\models\base\Schedule;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\helpers\FileHelper;

/**
 * Schedule
 *
 * Class ScheduleController
 * @package backend\modules\base\controllers
 */
class ScheduleController extends BaseController
{
    /**
      * @var Schedule
      */
    public $modelClass = Schedule::class;

    /**
      * @var string[]
      */
    public $likeAttributes = ['name'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $editAjaxFields = ['name', 'sort'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'name' => 'text',
        'type' => 'select',
    ];

    /**
      * 列表页
      *
      * @return string
      * @throws \yii\web\NotFoundHttpException
      */
    /*public function actionIndex()
    {
        $searchModel = new ModelSearch([
            'model' => $this->modelClass,
            'scenario' => 'default',
            'likeAttributes' => $this->likeAttributes,
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        // 管理员级别才能查看所有数据，其他只能查看本store数据
        $params = Yii::$app->request->queryParams;
        if (!$this->isAdmin()) {
            $params['ModelSearch']['store_id'] = $this->getStoreId();
        }
        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }*/

    /**
      * ajax编辑/创建
      *
      * @return mixed|string|\yii\web\Response
      * @throws \yii\base\ExitException
      */
    public function actionEditAjax()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->writeSchedule();
                $this->flashSuccess();
            } else {
                Yii::$app->logSystem->db($model->errors);
                $this->flashError($this->getError($model));
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @param $soft
     * @param $tree
     * @return bool|void
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    protected function afterDeleteModel($id, $soft = false, $tree = false)
    {
        $this->writeSchedule();
    }

    /**
     * 刷新执行文件
     *
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRefresh($id)
    {
        if ($this->writeSchedule()) {
            return $this->redirectSuccess(Yii::$app->request->referrer, '刷新执行文件成功');
        }
        return $this->redirectError(Yii::$app->request->referrer, '刷新失败，请查看后台数据库日志');
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    protected function writeSchedule()
    {
        $str = "<?php\n";
        $models = $this->modelClass::find()->where(['status' => $this->modelClass::STATUS_ACTIVE])->orderBy(['sort' => SORT_ASC])->all();
        foreach ($models as $model) {
            $str .= "\$schedule->command('{$model->name}')->cron('{$model->cron}');\n";
        }

        // 写入文件
        $scheduleFile = Yii::getAlias(Yii::$app->params['scheduleFile'] ?? '@console/runtime/schedule/schedule.php');
        $path = dirname($scheduleFile);
        if (!file_exists($path)) {
            if (!FileHelper::createDirectory($path)) {
                Yii::$app->logSystem->db('Create schedule path failed: ' . $path . ' ' . $str);
                return false;
            }
        }

        if (file_exists($scheduleFile)) {
            if (!FileHelper::unlink($scheduleFile)) {
                Yii::$app->logSystem->db('Unlink schedule path failed: ' . $path . ' ' . $str);
                return false;
            }
        }

        if (!file_put_contents($scheduleFile, $str)) {
            Yii::$app->logSystem->db('Write schedule failed: ' . $scheduleFile . ' ' . $str);
            return false;
        }
        return true;
    }
}
