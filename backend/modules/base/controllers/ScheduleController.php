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
      * 模糊查询字段
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
     * 导入导出字段
     *
     * @var int
     */
    protected $exportFields = [
        'id' => 'text',
        'name' => 'text',
        'type' => 'select',
    ];

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
    public function actionConfig()
    {
        if ($this->writeSchedule()) {
            return $this->redirectSuccess();
        }

        return $this->redirectError();
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
