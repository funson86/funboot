<?php

namespace common\components\controller;

use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\helpers\IdHelper;
use common\helpers\ResultHelper;
use common\models\BaseModel;
use common\models\Store;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Class BaseController
 * @package common\components
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends Controller
{
    /**
     * @var Store
     */
    protected $store;

    /**
     * @var Model
     */
    public $modelClass;

    /**
     * 默认分页
     *
     * @var int
     */
    protected $pageSize = 10;

    /**
     * 是否启用高并发
     * @var bool
     */
    protected $highConcurrency = false;


    public function beforeAction($action)
    {
        // 优先级从先到后：指定store_id，用户store_id，host_name，其中指定store_id放到session中，后续其他url无需再指定store_id也能匹配
        if (Yii::$app->request->get('store_id')) {
            $model = CommonHelper::getStoreById(intval(Yii::$app->request->get('store_id')));
            Yii::$app->session->set('currentStore', $model);
        } elseif (!is_null(Yii::$app->session->get('currentStore'))) {
            $model = Yii::$app->session->get('currentStore');
        } elseif (!Yii::$app->user->isGuest) {
            $model = CommonHelper::getStoreById(Yii::$app->user->identity->store_id);
        }
        // 前面两种都没有，则判断host_name
        if (!$model) {
            $model = CommonHelper::getStoreByHostName();
            if (!$model) {
                return  false;
            }
        }
        $this->store = $model;

        // 先赋值再去计算，然后再次对$model赋值
        $model->settings = Yii::$app->settingSystem->getSettings($model->id);
        $model->commonData = $this->commonData($model);
        $this->store = $model;
        Yii::$app->storeSystem->set($this->store);

        // 设置语言
        Yii::$app->language = CommonHelper::getLanguage($model);

        return parent::beforeAction($action);
    }

    /**
     * 返回模型
     *
     * @param $id
     * @param bool $emptyNew
     * @param bool $action
     * @return BaseModel
     * @throws \Exception
     */
    protected function findModel($id, $action = false)
    {
        /* @var $model \yii\db\ActiveRecord */
        $storeId = $this->getStoreId();
        if ((empty($id) || empty(($model = $this->modelClass::find()->where(['id' => $id])->andFilterWhere(['store_id' => $storeId])->one())))) {
            if ($action) {
                return null;
            }

            $model = new $this->modelClass();
            $model->loadDefaultValues();

            // 如果配置了高并发
            if ($this->highConcurrency || Yii::$app->params['highConcurrency']) {
                $model->id = IdHelper::snowFlakeId();
            }

            if (isset($model->store_id)) {
                $model->store_id = $this->getStoreId();
            }

            return $model;
        }

        return $model;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLoginBackend()
    {
        $token = Yii::$app->request->get('token', null);
        if (!$token) {
            throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));
        }

        $user = User::findByToken($token);
        if (!$user) {
            throw new ForbiddenHttpException(Yii::t('app', 'No Auth'));
        }

        if (Yii::$app->user->login($user, 4 * 3600)) {
            $user->token = '';
            if ($user->save()) {
                return $this->goHome();
            }
        }
        return $this->goBack();
    }

    /**
     * @return Store
     */
    public function getStore()
    {
        return $this->store;
    }


    /**
     * @return Store
     */
    public function getStores()
    {
        return Yii::$app->cacheSystem->getAllStore();
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->store->id ?? 0;
    }

    /**
     * @param $code
     * @return mixed|null
     */
    public function getSetting($code)
    {
        return Yii::$app->settingSystem->getValue($code, $this->getStoreId());
    }

    /**
     * @return mixed|null
     */
    public function getSettings()
    {
        return Yii::$app->settingSystem->getSettings($this->getStoreId());
    }

    /**
     * 根据store属性和配置计算通用数据，避免在controller或view中重复计算
     *
     * @param $model
     * @return array
     */
    protected function commonData($model)
    {
        return [];
    }

    /**
     * @param String $msg
     * @return string
     */
    protected function flashSuccess($msg = null)
    {
        $msg = $msg ? $msg : Yii::t('app', 'Operate Successfully');
        $this->setFlash('success', $msg);
    }

    /**
     * @param String $msg
     * @return string
     */
    protected function flashError($msg = null)
    {
        $msg = $msg ? $msg : Yii::t('app', 'Operation Failed');
        $this->setFlash('danger', $msg);
    }

    /**
     * @param String $msg
     * @return string
     */
    protected function flashWarning($msg = null)
    {
        $msg = $msg ? $msg : Yii::t('app', 'Operation Warning');
        $this->setFlash('warning', $msg);
    }

    /**
     * @param String $msg
     * @return string
     */
    protected function flashInfo($msg = null)
    {
        $msg = $msg ? $msg : Yii::t('app', 'Operation Info');
        $this->setFlash('info', $msg);
    }

    /**
     * 提示成功并跳转
     *
     * @param string|array $url 跳转链接
     * @param null $msg
     * @return mixed
     */
    protected function redirectSuccess($url = null, $msg = null)
    {
        !$url && $url = Yii::$app->request->referrer;
        $this->flashSuccess($msg);
        return $this->redirect($url);
    }

    /**
     * 保存日志，提示失败并跳转
     *
     * @param null $msg
     * @param string $url 跳转链接
     * @param bool $logDb
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    protected function redirectError($msg = null, $url = null, $logDb = false)
    {
        !$url && $url = Yii::$app->request->referrer;
        if ($msg instanceof Model) {
            Yii::$app->logSystem->db($msg->errors);
            $msg = $this->getError($msg);
        } elseif ($logDb) {
            Yii::$app->logSystem->db($msg->errors);
        }
        $this->flashError($msg);
        return $this->redirect($url);
    }

    /**
     * 提示失败并跳转
     *
     * @param string $url 跳转链接
     * @return mixed
     */
    protected function redirectWarning($url = null, $msg = null)
    {
        !$url && $url = Yii::$app->request->referrer;
        $this->flashWarning($msg);
        return $this->redirect($url);
    }

    /**
     * 提示失败并跳转
     *
     * @param string $url 跳转链接
     * @return mixed
     */
    protected function redirectInfo($url = null, $msg = null)
    {
        !$url && $url = Yii::$app->request->referrer;
        $this->flashInfo($msg);
        return $this->redirect($url);
    }

    /**
     * @param String $state
     * @param String $msg
     * @return string
     */
    protected function setFlash($state, $msg)
    {
        Yii::$app->getSession()->setFlash($state, $msg);
    }


    /**
     * response with error code which defined in /config/error.php
     *
     * @param  integer $code
     * @param  array $data
     * @param  array $map
     * @param  string $msg
     * @return array | mixed
     */
    protected function success($data = [], $map = [], $msg = '', $code = 200)
    {
        return ResultHelper::ret($code, $msg, $data, $map);
    }

    /**
     * response with error code which defined in /config/error.php
     *
     * @param  integer $code
     * @param  array $data
     * @param  string $msg
     * @return array | mixed
     */
    protected function error($code = 500, $msg = null, $data = [])
    {
        return ResultHelper::ret($code, $msg, $data);
    }

    /**
     * 返回html页面
     * @param $file
     * @param string $code
     * @param null $msg
     * @param null $title
     * @param array $config
     * @return array|string
     */
    protected function htmlSuccess($msg = null, $title = null, $config = [])
    {
        return ResultHelper::render(array_merge($config, [
            'code' => 'success',
            'msg' => $msg,
            'title' => $title,
        ]));
    }
    
    /**
     * 返回html页面
     * @param $file
     * @param string $code
     * @param null $msg
     * @param null $title
     * @param array $config
     * @return array|string
     */
    protected function htmlFailed($msg = null, $title = null, $config = [])
    {
        return ResultHelper::render(array_merge($config, [
            'code' => 'failed',
            'msg' => $msg,
            'title' => $title,
        ]));
    }

    /**
     * @param Model $model
     * @return string
     */
    protected function getError($model)
    {
        $firstErrors = $model->getFirstErrors();
        if (!is_array($firstErrors) || empty($firstErrors)) {
            return false;
        }

        $errors = array_values($firstErrors)[0];
        return $errors ? $errors : Yii::t('app', 'Uncaught Error');
    }

}