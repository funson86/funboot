<?php

namespace frontend\modules\cms\controllers;

use common\components\enums\YesNo;
use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\models\cms\Catalog;
use common\models\cms\Page;
use common\models\forms\base\FeedbackForm;
use common\models\Store;
use frontend\helpers\Url;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

/**
 * Default controller for the `cms` module
 */
class DefaultController extends BaseController
{

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $store = $this->getStore();
        if (!$store) {
            return false;
        }

        return true;
    }

    /**
     * 首页的显示规则，将第一个TYPE_MENU作为公司简介，将第一个TYPE_LIST作为新闻，第二个TYPE_LIST作为产品
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $store = $this->store;

        // 输入http://www.xxx.com/cms/可以预览网站，外界用户输入http://www.xxx.com显示正在开发
        if ($store->status != Store::STATUS_ACTIVE && Yii::$app->request->url == '/') {
            $this->module->setViewPath(null);
            $this->layout = 'empty';
            return $this->render($store->status);
        }

        return $this->render($store->settings['cms_template'] ?: $this->action->id, [
            'store' => $this->store,
            'banners' => $this->getStoreBanner(true),
        ]);

    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionList()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }

        if (!$this->model || $this->model->store_id != $this->store->id) {
            return $this->goHome();
        }

        $ids = ArrayHelper::getChildrenIds($id, $this->allCatalog);
        $query = Page::find()->where(['status' => Page::STATUS_ACTIVE, 'catalog_id' => $ids,]);

        $pagination = new Pagination([
            'defaultPageSize' => $this->model->page_size > 0 ? $this->model->page_size : ($this->store->settings['cms_list_page_size'] ?: 12),
            'totalCount' => $query->count(),
        ]);

        $models = $query->orderBy(['created_at' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();
        foreach ($models as &$model) {
            $model = $this->buildLang($model, Page::getTableCode());
        }

        return $this->render($this->model->template ?: $this->action->id, [
            'model' => $this->model,
            'models' => $models,
            'pagination' => $pagination,
            'store' => $this->store,
        ]);
    }

    public function actionMenu()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }

        if (!$this->model || $this->model->store_id != $this->store->id) {
            return $this->goHome();
        }

        return $this->render($this->model->template ?: $this->action->id, [
            'model' => $this->model,
            'store' => $this->store,
        ]);
    }

    public function actionPage()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }

        if (!$this->model || $this->model->store_id != $this->store->id) {
            return $this->goHome();
        }

        // 如果是跳转到其他页面
        if (strlen($this->model->redirect_url) > 5) {
            return $this->redirect($this->model->redirect_url);
        }

        $prev = Page::find()->where('id < ' . $id)->andWhere(['catalog_id' => $this->model->catalog_id, 'status' => Page::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC])->one();
        $next = Page::find()->where('id > ' . $id)->andWhere(['catalog_id' => $this->model->catalog_id, 'status' => Page::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->one();

        $model = $this->buildLang($this->model, Page::getTableCode());
        $template = isset($this->mapAllCatalog[$this->model->catalog_id]['template_page']) ? $this->mapAllCatalog[$this->model->catalog_id]['template_page'] : 'page';
        return $this->render($template ?: $this->action->id, [
            'model' => $model,
            'store' => $this->store,
            'prev' => $prev,
            'next' => $next,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionContact()
    {
        $model = new FeedbackForm();
        $model->checkCaptchaRequired();

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            $this->flashSuccess(Yii::t('app', 'Thank you for your comment, we will contact you as soon as possible.'));
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionSearch()
    {
        $keyword = Yii::$app->request->get('keyword', null);
        $catalogId = Yii::$app->request->get('catalog_id', 0);
        if (!$keyword || strlen(trim($keyword)) < 1) {
            return $this->goBack();
        }

        $store = $this->store;

        $query = Page::find()
            ->where(['status' => Page::STATUS_ACTIVE, 'store_id' => $this->store->id,])
            ->andWhere(['or', ['like', 'name', $keyword], ['like', 'content', $keyword]]);
        if ($catalogId > 0 && isset($this->mapAllCatalog[$catalogId])) {
            $rootId = ArrayHelper::getRootId($catalogId, $this->allCatalog);
            $ids = ArrayHelper::getChildrenIds($rootId, $this->allCatalog);
            $query->andWhere(['catalog_id' => $ids]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $query->count(),
        ]);

        $models = $query->orderBy(['created_at' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render($this->action->id, [
            'catalogId' => isset($rootId) ? $rootId : $catalogId,
            'keyword' => $keyword,
            'models' => $models,
            'pagination' => $pagination,
            'store' => $store,
        ]);
    }
}
