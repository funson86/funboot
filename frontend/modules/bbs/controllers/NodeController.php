<?php

namespace frontend\modules\bbs\controllers;

use common\models\bbs\Node;
use common\models\bbs\Topic;
use common\models\ModelSearch;
use Yii;

/**
 * Default controller for the `bbs` module
 */
class NodeController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ModelSearch([
            'model' => Topic::class,
            'scenario' => 'default',
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        // 管理员级别才能查看所有数据，其他只能查看本store数据
        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['store_id'] = $this->getStoreId();
        $params['ModelSearch']['node_id'] = $this->id;
        $params['ModelSearch']['status'] = Topic::STATUS_ACTIVE;

        // 判断节点
        if ($node = Yii::$app->request->get('node')) {
            if (!is_int($node)) {
                $modelTemp = Node::find()->where(['surname', $node])->one();

                $node = $modelTemp ? $modelTemp->id : null;
            }

            if (!is_null($node)) {
                $params['ModelSearch']['node_id'] = Topic::STATUS_DELETED;
            }
        }

        $dataProvider = $searchModel->search($params);

        // 排序
        $sort = $dataProvider->getSort();
        $sort->attributes['id']['asc'] = ['id' => SORT_DESC];
        $sort->attributes['like']['asc'] = ['like' => SORT_DESC, 'id' => SORT_DESC];
        $sort->attributes['click']['asc'] = ['click' => SORT_DESC, 'id' => SORT_DESC];

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
