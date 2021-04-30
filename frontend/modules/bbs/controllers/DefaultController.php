<?php

namespace frontend\modules\bbs\controllers;

use common\helpers\ArrayHelper;
use common\models\bbs\Node;
use common\models\bbs\Topic;
use common\models\LoginForm;
use common\models\ModelSearch;
use Yii;

/**
 * Default controller for the `bbs` module
 */
class DefaultController extends BaseController
{
    public $likeAttributes = ['name'];

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ModelSearch([
            'model' => Topic::class,
            'scenario' => 'default',
            'likeAttributes' => $this->likeAttributes,
            'defaultOrder' => [
                'sort' => SORT_ASC,
                'id' => SORT_DESC,
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        // 管理员级别才能查看所有数据，其他只能查看本store数据
        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['store_id'] = $this->getStoreId();
        $params['ModelSearch']['status'] = Topic::STATUS_ACTIVE;
        if ($nodeId = Yii::$app->request->get('node_id')) {
            $nodeIds = ArrayHelper::getChildrenIds($nodeId, Node::find()->all());
            $params['ModelSearch']['node_id'] = $nodeIds;
        }

        // 判断节点
        if ($nodeId = Yii::$app->request->get('id')) {
            $node = Node::find()->where(['id' => $nodeId, 'store_id' => $this->getStoreId()])->one();
            if ($node) {
                $params['ModelSearch']['node_id'] = $node->id;
            }
        }

        $dataProvider = $searchModel->search($params);

        // 排序
        $sort = $dataProvider->getSort();
        $sort->attributes['id']['asc'] = ['id' => SORT_DESC];
        $sort->attributes['like']['asc'] = ['like' => SORT_DESC, 'id' => SORT_DESC];
        $sort->attributes['click']['asc'] = ['click' => SORT_DESC, 'id' => SORT_DESC];

        return $this->render('../node/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
