<?php

namespace common\components\controller;

use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\helpers\ResultHelper;
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


    public function beforeAction($action)
    {
        $allStore = Yii::$app->cacheSystem->getAllStore();
        $mapHostNameId = ArrayHelper::map($allStore, 'host_name', 'id');
        $mapIdStore = ArrayHelper::mapIdData($allStore);

        // 计算store，如果没有则使用默认的store
        $hostName = Yii::$app->request->hostName;
        $storeId = $mapHostNameId[$hostName] ?? null;
        if ($storeId) {
            $model = $mapIdStore[$storeId];
        } else {
            $model = Store::findOne(Yii::$app->params['defaultStoreId']);
        }

        $this->store = $model;
        $model->settings = Yii::$app->settingSystem->getSettings($model->id);
        $model->commonData = $this->commonData($model);
        $this->store = $model;
        Yii::$app->storeSystem->set($this->store);

        // 设置语言
        $this->setLanguage();

        $this->enableCsrfValidation = false; // 有风险需改进
        return parent::beforeAction($action);
    }

    /**
     * 返回模型
     *
     * @param $id
     * @param bool $emptyNew
     * @param bool $highConcurrency
     * @return \yii\db\ActiveRecord
     * @throws \Exception
     */
    protected function findModel($id, $highConcurrency = false)
    {
        /* @var $model \yii\db\ActiveRecord */
        $storeId = $this->getStoreId();
        if ((empty($id) || empty(($model = $this->modelClass::find()->where(['id' => $id])->andFilterWhere(['store_id' => $storeId])->one())))) {
            $model = new $this->modelClass();
            $model->loadDefaultValues();

            // 如果配置了高并发
            if ($highConcurrency || Yii::$app->params['highConcurrency']) {
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
     * @return mixed
     */
    protected function redirectSuccess($url, $msg = null)
    {
        $this->flashSuccess($msg);
        return $this->redirect($url);
    }

    /**
     * 提示失败并跳转
     *
     * @param string $url 跳转链接
     * @return mixed
     */
    protected function redirectError($url, $msg = null)
    {
        $this->flashError($msg);
        return $this->redirect($url);
    }

    /**
     * 提示失败并跳转
     *
     * @param string $url 跳转链接
     * @return mixed
     */
    protected function redirectWarning($url, $msg = null)
    {
        $this->flashWarning($msg);
        return $this->redirect($url);
    }

    /**
     * 提示失败并跳转
     *
     * @param string $url 跳转链接
     * @return mixed
     */
    protected function redirectInfo($url, $msg = null)
    {
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

    protected function setLanguage()
    {
        $lang = Yii::$app->cacheSystem->getLanguage(Yii::$app->user->id ?? 0, Yii::$app->session->id);
        if (!$lang) {
            $lang = CommonHelper::parseBrowserLanguage();
        }

        $langInt = Store::getLanguageCode($lang, true, true);
        if (!(($langInt & $this->store->language) == $langInt)) {
            $lang = Yii::$app->params['defaultBackendLanguage'];
        }

        return Yii::$app->language = $lang;
    }

}