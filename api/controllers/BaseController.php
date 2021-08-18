<?php

namespace api\controllers;

use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\helpers\IdHelper;
use common\models\Store;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

/**
 * Class BaseController
 * @package frontend\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends ActiveController
{
    /**
     * @var Model
     */
    public $modelClass;

    /**
     * 不需要使用modelClass，'*'所有方法无需判断
     * @var string[]
     */
    public $skipModelClass = [];

    /**
     * @var Store
     */
    protected $store;

    /**
     * 列表默认排序
     * @var array[]
     */
    protected $defaultOrder = ['sort' => SORT_ASC, 'id' => SORT_DESC];

    /**
     * 默认分页
     *
     * @var int
     */
    protected $pageSize = 10;

    /**
     * 序列化数据
     * @var string[]
     */
    public $serializer = [
        'class' => 'api\components\response\Serializer',
        'collectionEnvelope' => 'data',
        'metaEnvelope' => 'map',
    ];

    /**
     * 要鉴权中不需要鉴权的action id
     * @var string[]
     */
    public $optionalAuth = [];

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法，只保留option
        unset($actions['index'], $actions['view'], $actions['update'], $actions['create'], $actions['view'], $actions['delete']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                // HttpBasicAuth::className(),
                // HttpBearerAuth::className(),
                [
                    'class' => HttpHeaderAuth::className(),
                    'header' => 'access-token',
                ],
                [
                    'class' => QueryParamAuth::className(),
                    'tokenParam' => 'access-token',
                ],
            ],
            // 忽略的action id
            'optional' => $this->optionalAuth,
        ];

        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::class,
            'enableRateLimitHeaders' => true,
        ];

        return $behaviors;

    }

    /**
     * 根据
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // 鉴权 如自定义RBAC方式
        $this->checkAccess($action->id, $this->modelClass, Yii::$app->request->get());

        $model = CommonHelper::getStoreByHostName();
        $this->store = $model;
        $model->settings = Yii::$app->settingSystem->getSettings($model->id);
        $model->commonData = $this->commonData($model);
        $this->store = $model;
        Yii::$app->storeSystem->set($this->store);

        // 设置语言
        Yii::$app->language = CommonHelper::getLanguage($model);

        // 不是通配符 且不再忽略名单中，modelClass不是Model子类
        if ($this->skipModelClass != '*' && !in_array($this->action->id, $this->skipModelClass) && !is_subclass_of($this->modelClass, Model::class)) {
            return false;
        }

        return true;
    }

    /**
     * 首页
     *
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => $this->modelClass::find()
                ->where(['status' => $this->modelClass::STATUS_ACTIVE])
                ->andFilterWhere(['store_id' => $this->getStoreId()])
                ->orderBy($this->defaultOrder),
            'pagination' => [
                'pageSize' => $this->pageSize,
                'validatePage' => false,// 超出分页不返回data
            ],
        ]);
    }

    /**
     * 查看单条记录
     *
     * @return ActiveDataProvider
     */
    public function actionView($id)
    {
        $model = $this->findModel($id, true);
        if (!$model) {
            return $this->error();
        }

        return $model;
    }

    /**
     * 新增
     * @return mixed|\yii\db\ActiveRecord
     * @throws \Exception
     */
    public function actionCreate()
    {
        if (!$this->modelClass) {
            return $this->error(500);
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass;
        $model->attributes = Yii::$app->request->post();

        if (!$model->save()) {
            return $this->error();
        }

        return $model;
    }

    /**
     * 更新
     * @return mixed|\yii\db\ActiveRecord
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        if (!$this->modelClass) {
            return $this->error();
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = $this->findModel($id, true);
        if (!$model) {
            return $this->error();
        }

        $model->attributes = Yii::$app->request->post();
        if (!$model->save()) {
            return $this->error(422);
        }

        return $model;
    }


    /**
     * 删除
     * delete?soft=true 软删除，状态变成删除状态
     * delete?tree=true 树状删除，删除所有
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id, true);
        if (!$model) {
            return $this->error();
        }

        $soft = Yii::$app->request->get('soft', true);
        $tree = Yii::$app->request->get('tree', false);
        if ($tree) {
            $ids = ArrayHelper::getChildrenIds($id, $this->modelClass::find()->asArray()->all());
        } else {
            $ids = $id;
        }
        $this->beforeDeleteModel($ids, $soft, $tree);

        if ($soft) {
            $model->status = $this->modelClass::STATUS_DELETED;
            $result = $model->save();
        } else {
            $result = $model->delete();
        }

        if (!$result) {
            Yii::$app->logSystem->db($model->errors);
            return $this->error();
        }

        if ($tree) {
            if ($soft) {
                $this->modelClass::updateAll(['status' => $this->modelClass::STATUS_DELETED], ['id' => $ids]);
            } else {
                $this->modelClass::deleteAll(['id' => $ids]);
            }
        }

        $this->afterDeleteModel($id, $soft = false, $tree = false);
        return $this->success();
    }

    /**
     * 删除动作前处理，子方法只需覆盖该函数即可
     * @param $id
     * @param bool $soft
     * @param bool $tree
     * @return bool
     */
    protected function beforeDeleteModel($id, $soft = false, $tree = false)
    {
        return true;
    }

    /**
     * 删除动作后处理，子方法只需覆盖该函数即可
     * @param $id
     * @param bool $soft
     * @param bool $tree
     * @return bool
     */
    protected function afterDeleteModel($id, $soft = false, $tree = false)
    {
        return true;
    }

    /**
     * 要操作的必须先查询有权限的ID
     * @param $id
     * @param bool $action
     * @return mixed|null |null
     */
    protected function findModel($id, $action = true)
    {
        $storeId = $this->getStoreId();
        if ((empty($id) || empty(($model = $this->modelClass::find()->where(['id' => $id, 'status' => $this->modelClass::STATUS_ACTIVE])->andFilterWhere(['store_id' => $storeId])->one())))) {
            if ($action) {
                return null;
            }

            $model = new $this->modelClass();
        }

        return $model;
    }

    /**
     * @param mixed $data
     * @param array $map
     * @param string $msg
     * @param int $code
     * @return mixed
     */
    protected function success($data = null, $map = [], $msg = '', $code = 200)
    {
        return Yii::$app->responseSystem->success($data, $map, $msg, $code);
    }

    /**
     * @param int $code
     * @param null $msg
     * @param array $data
     * @return mixed
     */
    protected function error($code = 422, $msg = null, $data = [])
    {
        return Yii::$app->responseSystem->error($code, $msg, $data);
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
     * @param $model
     * @return array
     */
    protected function commonData($model)
    {
        return [];
    }
}
