<?php

namespace backend\modules\wechat\controllers;

use common\services\wechat\TagService;
use Yii;
use common\models\wechat\Tag;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Tag
 *
 * Class TagController
 * @package backend\modules\wechat\controllers
 */
class TagController extends BaseController
{
    /**
      * @var Tag
      */
    public $modelClass = Tag::class;

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

    public function actionIndex()
    {
        $storeId = $this->getStoreId();
        $model = $this->modelClass::find()->andFilterWhere(['store_id' => $storeId])->one();
        if (!$model || empty($model->tags)) {
            TagService::syncAll();
            $model = $this->modelClass::find()->andFilterWhere(['store_id' => $storeId])->one();
        }


        return $this->render($this->action->id, [
            'models' => $model->tags ?? [],
            //'pages' => $pages
        ]);
    }

    public function actionEditSync()
    {
        TagService::syncAll();

        return $this->redirectSuccess();
    }

    public function actionEditAjax()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!isset($post['Tag']['name']) || strlen($post['Tag']['name']) <= 0) {
                return $this->redirectError();
            }

            Yii::$app->wechat->app->user_tag->create($post['Tag']['name']);
            TagService::syncAll();

            return $this->redirectSuccess();
        }

        $model = new $this->modelClass;
        return $this->renderAjax(Yii::$app->request->get('view') ?? $this->viewFile ?? $this->action->id, [
            'model' => $model,
        ]);

    }

    public function actionEditAjaxField()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->error();
        }

        if ($value = Yii::$app->request->post('value')) {
            Yii::$app->wechat->app->user_tag->update($id, $value);
        }

        TagService::syncAll();

        return $this->success(null, null, Yii::t('app', 'Edit Successfully'));
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        Yii::$app->wechat->app->user_tag->delete($id);
        TagService::syncAll();

        return $this->redirectSuccess();
    }

}
