<?php

namespace frontend\modules\bbs\controllers;

use common\job\base\CounterJob;
use common\models\bbs\Comment;
use common\models\bbs\Meta;
use common\models\bbs\Node;
use common\models\bbs\Topic;
use common\models\bbs\TopicMeta;
use common\models\bbs\TopicTag;
use common\models\ModelSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `bbs` module
 */
class TopicController extends BaseController
{
    public $modelClass = Topic::class;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($id)
    {
        $model = Topic::find()->where(['store_id' => $this->getStoreId(), 'id' => $id, 'status' => Topic::STATUS_ACTIVE])->one();
        if (!$model) {
            return $this->goBack();
        }

        Yii::$app->queue->push(new CounterJob(['modelClass' => Topic::class, 'id' => $id]));

        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->with('user')->where(['topic_id' => $id]),
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]]
        ]);

        return $this->render($this->action->id, [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id', null);
        $nodeId = Yii::$app->request->get('node_id', null);
        $model = $this->findModel($id);
        if (!($model->node_id > 0 || $nodeId)) {
            return $this->redirect(['edit-node']);
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post();

                if (!$model->save()) {
                    Yii::$app->logSystem->db($model->errors);
                    return $this->redirectError();
                } else {
                    if (isset($post['Meta']) && is_array($post['Meta'])) {
                        foreach ($post['Meta'] as $k => $v) {
                            $meta = Meta::findOne(['id' => $k, 'store_id' => $this->getStoreId()]);
                            if (!$meta) {
                                continue;
                            }

                            $topicMeta = TopicMeta::find()->where(['topic_id' => $model->id, 'meta_id' => $k, 'store_id' => $this->getStoreId()])->one();
                            if (!$topicMeta) {
                                $topicMeta = new TopicMeta();
                                $topicMeta->store_id = $this->getStoreId();
                                $topicMeta->topic_id = $model->id;
                                $topicMeta->meta_id = $k;
                                $topicMeta->name = $meta->name;
                            }
                            $topicMeta->content = trim($v);
                            if (!$topicMeta->save()) {
                                Yii::$app->logSystem->db($topicMeta->errors);
                                return $this->redirectError();
                            }
                        }
                    }
                }
                return $this->redirectSuccess(['/bbs/topic/view', 'id' => $model->id]);
            }
        }

        $fromId = Yii::$app->request->get('from_id', null);
        $from = Topic::findOne(['id' => $fromId, 'store_id' => $this->getStoreId()]);
        !$model->node_id && $model->node_id = Yii::$app->request->get('node_id') ?? $from->node_id;
        if ($model->node_id > 0) {
            $node = Node::find()->where(['id' => $model->node_id])->one();
            if ($node && $node->meta_id > 0) {
                $meta = Meta::find()->where(['id' => $node->meta_id])->with('children')->one();
            }
        }
        $metas = isset($meta) ? $meta->children : [];

        if ($id > 0) {
            $topicMetas = TopicMeta::find()->where(['store_id' => $this->getStoreId(), 'topic_id' => $id])->all();
            $mapMetaIdContent = ArrayHelper::map($topicMetas, 'meta_id', 'content');
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'metas' => $metas ?? [],
            'mapMetaIdContent' => $mapMetaIdContent ?? [],
        ]);

    }

    public function actionEditNode()
    {
        $id = Yii::$app->request->get('id', null);

        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->node_id > 0) {
                    return $this->redirect(['edit', 'node_id' => $model->node_id]);
                }
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);

    }

    public function actionDelete($id)
    {
        if (!$model = $this->findModel($id, true)) {
            return $this->goBack();
        }

        if (!($this->isAdmin() || $model->isOwer())) {
            return $this->goBack();
        }

        Comment::deleteAll(['store_id' => $this->getStoreId(), 'topic_id' => $id]);
        TopicMeta::deleteAll(['store_id' => $this->getStoreId(), 'topic_id' => $id]);
        TopicTag::deleteAll(['store_id' => $this->getStoreId(), 'topic_id' => $id]);
        $model->delete();

        return $this->redirectSuccess();
    }

    public function actionExcellent($id)
    {
        if (!$this->isAdmin() || !$model = $this->findModel($id, true)) {
            return $this->goBack();
        }

        $model->kind = Yii::$app->request->get('cancel') ? Topic::KIND_NORMAL : Topic::KIND_EXCELLENT;
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return $this->redirectError();
        }

        return $this->redirectSuccess();
    }

    public function actionTop($id)
    {
        if (!$this->isAdmin() || !$model = $this->findModel($id, true)) {
            return $this->goBack();
        }

        $model->sort = Yii::$app->request->get('cancel') ? Topic::SORT_DEFAULT : Topic::SORT_TOP;
        if (!$model->save()) {
            Yii::$app->logSystem->db($model->errors);
            return $this->redirectError();
        }

        return $this->redirectSuccess();
    }
}
