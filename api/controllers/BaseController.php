<?php

namespace api\controllers;

use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\models\Store;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;

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
     * 模糊查询字段
     *
     * @var int
     */
    protected $likeAttributes = ['name'];

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
     * 是否高并发
     * @var bool
     */
    protected $highConcurrency = false;

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
     * @OA\Get(
     *     path="/api/xxx/users",
     *     tags={"Base"},
     *     summary="List records",
     *     description="list ?page=2 pagination  ?name='funson&created_at=>1648607050 search",
     *     @OA\Parameter(name="access-token", required=true, @OA\Schema(type="string"), in="header", description="login access token"),
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function actionIndex()
    {
        $query = $this->modelClass::find()
            ->where(['>', 'status', $this->modelClass::STATUS_DELETED])
            ->andFilterWhere(['store_id' => $this->getStoreId()]);
        foreach (Yii::$app->request->get() as $field => $value) {
            if (in_array($field, $this->modelClass::getTableSchema()->getColumnNames())) {
                if (in_array($field, $this->likeAttributes)) {
                    $query->andWhere(['like', $field, trim($value)]);
                } else {
                    $query->andWhere($this->conditionTrans($field, $value));
                }
            }
        }
        $query->orderBy($this->defaultOrder);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
                'validatePage' => false,// 超出分页不返回data
            ],
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/xxx/users/{id}",
     *     tags={"Base"},
     *     summary="View one record",
     *     description="View one record",
     *     @OA\Parameter(name="access-token", required=true, @OA\Schema(type="string"), in="header", description="login access token"),
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function actionView()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->error();
        }

        $model = $this->findModel($id, true);
        if (!$model) {
            return $this->error();
        }

        return $model;
    }

    /**
     * @OA\Post(
     *     path="/api/xxx/users",
     *     tags={"Base"},
     *     summary="Create a new record",
     *     description="Create a new record",
     *     @OA\Parameter(name="access-token", required=true, @OA\Schema(type="string"), in="header", description="login access token"),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(property="name", type="string", description="Name"),
     *           )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success")
     * )
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
     * @OA\Put(
     *     path="/api/xxx/users/{id}",
     *     tags={"Base"},
     *     summary="Update a record",
     *     description="Update a record",
     *     @OA\Parameter(name="access-token", required=true, @OA\Schema(type="string"), in="header", description="login access token"),
     *     @OA\Parameter(name="id", required=true, @OA\Schema(type="string"), in="path", description="id"),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(property="name", type="string", description="Name"),
     *           )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->error();
        }

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
     * @OA\Delete(
     *     path="/api/xxx/users/{id}",
     *     tags={"Base"},
     *     summary="Delete a record",
     *     description="Delete a record, delete?soft=true delete softly, status to STATUS_DELETED. delete?tree=true delete include the data which parent_id matched",
     *     @OA\Parameter(name="access-token", required=true, @OA\Schema(type="string"), in="header", description="login access token"),
     *     @OA\Parameter(name="id", required=true, @OA\Schema(type="string"), in="path", description="id"),
     *     @OA\Parameter(name="soft", required=false, @OA\Schema(type="string"), in="path", description="soft"),
     *     @OA\Parameter(name="tree", required=false, @OA\Schema(type="string"), in="path", description="tree"),
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->error();
        }

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
        if ((empty($id) || empty(($model = $this->modelClass::find()->where(['id' => $id])->andFilterWhere(['store_id' => $storeId])->one())))) {
            if ($action) {
                return null;
            }

            $model = new $this->modelClass();
        }

        return $model;
    }

    /**
     * 可以查询大于小于和IN
     *
     * @param $attributeName
     * @param $value
     * @return array
     */
    private function conditionTrans($attributeName, $value)
    {
        switch (true) {
            case is_array($value):
                return [$attributeName => $value];
                break;
            case stripos($value, '>=') !== false:
                return ['>=', $attributeName, substr($value, 2)];
                break;
            case stripos($value, '<=') !== false:
                return ['<=', $attributeName, substr($value, 2)];
                break;
            case stripos($value, '<') !== false:
                return ['<', $attributeName, substr($value, 1)];
                break;
            case stripos($value, '>') !== false:
                return ['>', $attributeName, substr($value, 1)];
                break;
            case stripos($value, ',') !== false:
                return [$attributeName => explode(',', $value)];
                break;
            default:
                return [$attributeName => $value];
                break;
        }
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
