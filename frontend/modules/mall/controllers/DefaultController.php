<?php

namespace frontend\modules\mall\controllers;

use common\models\ModelSearch;
use common\models\Store;
use Yii;

/**
 * Default controller for the `mall` module
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
        /*if ($this->store->parent_id == 0) {
            return $this->actionIndexPlatform();
        }*/

        return $this->render($this->action->id);
    }

    /**
     * 支持平台类型  www.funmall.com/mall-yongchang
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndexPlatform()
    {
        $this->layout = 'main-platform';
        $searchModel = new ModelSearch([
            'model' => Store::class,
            'scenario' => 'default',
            'likeAttributes' => $this->likeAttributes,
            'defaultOrder' => [
                'status' => SORT_ASC,
                'sort' => SORT_ASC,
                'id' => SORT_DESC,
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        // 管理员级别才能查看所有数据，其他只能查看本store数据
        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['parent_id'] = $this->getStoreId();
        $params['ModelSearch']['status'] = Store::STATUS_ACTIVE;

        $listChildren = [];
        $dataProvider = $searchModel->search($params);

        // 排序
        $sort = $dataProvider->getSort();
        $sort->attributes['id']['asc'] = ['status' => SORT_ASC, 'id' => SORT_DESC];
        $sort->attributes['like']['asc'] = ['status' => SORT_ASC, 'like' => SORT_DESC, 'id' => SORT_DESC];
        $sort->attributes['click']['asc'] = ['status' => SORT_ASC, 'click' => SORT_DESC, 'id' => SORT_DESC];

        return $this->render('index-platform', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'listChildren' => $listChildren,
        ]);
    }
}
