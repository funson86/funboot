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
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\web\Controller;

/**
 * Default controller for the `cms` module
 */
class DefaultController extends BaseController
{
    // 菜单栏显示的一级栏目
    public $mainMenu = [];

    // 菜单栏显示的二级栏目
    public $mainMenu2 = [];

    // 如果是内页，计算侧边栏的二级栏目
    public $portlet;

    // 当前页面所属栏目的顶级栏目，用于计算顶级栏目是否active
    public $rootCatalog;

    // 所有的
    public $allCatalog;

    // 根据ID查找catalog
    public $mapAllCatalog;

    // 所有显示的栏目
    public $allShowCatalog = [];

    // 判断是否为手机版
    public $isMobile;

    //模板
    public $theme;

    // 资源文件前缀
    public $prefixStatic;

    // banner
    public $banner;

    // model
    public $model;

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

        $this->theme = $store->settings['cms_theme'] ?? 'default';
        $this->module->setViewPath('@webroot/resources/cms/' . $this->theme . '/views');
        $this->layout = 'main';
        $this->prefixStatic = Yii::getAlias('@web/resources/' . $store->route . '/' . $this->theme);
        $this->isMobile = CommonHelper::isMobile();

        //menu
        $this->allCatalog = Catalog::find()
            ->where(['store_id' => $store->id,])
            ->andWhere('code <> "default"')
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();

        foreach ($this->allCatalog as $item) {
            $item->name = fbt(Catalog::getTableCode(), $item->id, 'name', $item->name);
            $this->mapAllCatalog[$item['id']] = $item;
            if ($item->status == Catalog::STATUS_ACTIVE && $item->is_nav == YesNo::YES) {
                $this->allShowCatalog[] = $item->attributes;
            }
        }

        //根据action_id 计算model和root id
        // banner规则 index的banner为系统的，list/menu看自己有没有，没有找父节点的，再没有找系统的。page找当前分类的banner，，没有找父分类的，再没有找系统的。
        $this->model = null;
        $catalogId = 0;
        if (in_array($this->action->id, ['list', 'menu'])) {
            $catalogId = Yii::$app->request->get('id');
            $catalogId && $this->model = Catalog::findOne($catalogId);
            $this->model->name = fbt(Catalog::getTableCode(), $this->model->id, 'name', $this->model->name);
            $this->model->brief = fbt(Catalog::getTableCode(), $this->model->id, 'brief', $this->model->brief);
            $this->model->content = fbt(Catalog::getTableCode(), $this->model->id, 'content', $this->model->content);

            $this->banner = $this->getCatalogBanner($catalogId);
        } elseif ($this->action->id == 'page') {
            $id = Yii::$app->request->get('id');
            $id && $this->model = Page::findOne($id);
            $this->model && $catalogId = $this->model->catalog_id;
            $this->model = $this->buildLang($this->model, Page::getTableCode());

            $bannerName = $this->isMobile ? 'banner_h5' : 'banner';
            $this->banner = !empty($this->model->$bannerName) ? $this->model->$bannerName : $this->getCatalogBanner($catalogId);
        } elseif ($this->action->id == 'index') {
            $this->banner = $this->getStoreBanner(true);
        }
        $rootCatalogId = $catalogId ? ArrayHelper::getRootId($catalogId, $this->allCatalog) : 0;

        $home = ['url' => Url::to(['/']), 'name' => Yii::t('app', 'Home'), 'label' => Yii::t('app', 'Home'), 'active' => ($this->action->id == 'index')];
        $this->mainMenu[0] = $this->mainMenu2[0] = $home;

        foreach ($this->allShowCatalog as $catalog) {
            $name = fbt(Catalog::getTableCode(), $catalog['id'], 'name', $catalog['name']);
            $item = ['id' => $catalog['id'], 'name' => $name, 'label' => $name, 'active'=> ($catalog['id'] == $rootCatalogId)];
            if ($catalog['type'] == 'link') {// redirect to other site
                $item['url'] = $catalog['redirect_url'];
            } else {
                $item['url'] = Url::to(['/cms/default/' . $catalog['type'] . '/', 'id' => $catalog['id']]);
            }

            !empty($item) && array_push($this->mainMenu, $item);
        }

        // sub menu 2
        $allCatalog2 = ArrayHelper::getTreeIdLabel(0, $this->allShowCatalog, '');
        foreach ($allCatalog2 as $catalog) {
            $name = fbt(Catalog::getTableCode(), $catalog['id'], 'name', $catalog['name']);
            $item = ['id' => $catalog['id'], 'name' => $name, 'label' => $name, 'active' => ($catalog['id'] == $rootCatalogId)];
            if ($catalog['type'] == 'link') {// redirect to other site
                $item['url'] = $catalog['link'];
            } else {
                $item['url'] = Url::to(['/cms/default/' . $catalog['type'] . '/', 'id' => $catalog['id']]);
            }

            if ($catalog['parent_id'] == 0) {
                $this->mainMenu2[$catalog['id']] = $item;
            } else {
                if (isset($this->mainMenu2[$catalog['parent_id']])) {
                    $this->mainMenu2[$catalog['parent_id']]['items'][$catalog['id']] = $item;
                }
            }
        }

        $this->portlet = ArrayHelper::getRootSub2($rootCatalogId, $allCatalog2);
        $this->rootCatalog =$this->mapAllCatalog[$rootCatalogId] ?? 0;

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

    /**
     * @param bool $index
     * @return array|\common\models\base\Setting|mixed|string|string[]
     */
    public function getStoreBanner($index = false)
    {
        $bannerName = $this->isMobile ? 'cms_banner_h5' : 'cms_banner';
        $bannerData = $this->store->settings[$bannerName];
        $banners = is_array($bannerData) ? $bannerData : json_decode($bannerData, true);

        if (!$banners || empty($banners)) {
            $banners = [$this->getImageResponsive('banner-h5-01'), $this->getImageResponsive('banner-h5-02'), ];
        }

        if ($index) {
            return is_array($banners) ? $banners : [];
        }

        return $banners[0] ?? [];
    }


    /**
     * 计算banner index的banner为系统的，list/menu看自己有没有，没有找父节点的，再没有找系统的。page找当前分类的banner，，没有找父分类的，再没有找系统的。
     * @return mixed
     */
    public function getCatalogBanner($catalogId)
    {
        $bannerName = $this->isMobile ? 'banner_h5' : 'banner';

        $banner = null;
        $catalogId = intval($catalogId);

        if (isset($this->mapAllCatalog[$catalogId]) && !empty($this->mapAllCatalog[$catalogId][$bannerName])) {
            $banner = $this->mapAllCatalog[$catalogId][$bannerName];
        } elseif (isset($this->mapAllCatalog[$catalogId]) && empty($this->mapAllCatalog[$catalogId][$bannerName])) {
            $parentCatalog = $this->mapAllCatalog[$this->mapAllCatalog[$catalogId]['parent_id']] ?? null;
            if (isset($parentCatalog) && !empty($parentCatalog[$bannerName])) {
                $banner = $parentCatalog[$bannerName];
            }
        }

        !$banner && $banner = $this->getStoreBanner();
        return $banner;
    }

    public function getBlock($code)
    {
        if (!$code) {
            return '';
        }

        return Yii::$app->cacheSystemCms->getPageByCode($code);
    }

    public function getBlockValue($code = 'contact_us', $field = 'name', $lang = null)
    {
        if (!$code) {
            return '';
        }

        $model = Yii::$app->cacheSystemCms->getPageByCode($code);
        if (!$model) {
            return '';
        }

        !$lang && $lang = Yii::$app->language;
        if (in_array($field, array_keys(Page::$mapLangFieldType))) {
            return Yii::$app->cacheSystem->getLang(Page::getTableCode(), $model->id, $field, $model->$field, $lang);
        }
        return $model->$field ?? '';
    }

    public function getBlockValueIndex($index = 0, $code = 'contact_us', $field = 'name', $lang = null, $split = '|')
    {
        $value = $this->getBlockValue($code, $field, $lang);
        $arr = explode($split, $value);
        return $arr[$index] ?? $arr[0];
    }

    public function getBlockFieldIndex($index = 0, $code = 'contact_us', $field = 'name', $split = '|')
    {
        $model = Yii::$app->cacheSystemCms->getPageByCode($code);
        if (!$model) {
            return '';
        }

        $value = $model->$field ?: '';
        $arr = explode($split, $value);
        return $arr[$index] ?? $arr[0];
    }

    protected function buildLang($model, $tableCode)
    {
        if (!$model) {
            return $model;
        }

        $model->name = fbt($tableCode, $model->id, 'name', $model->name);
        $model->brief = fbt($tableCode, $model->id, 'brief', $model->brief);
        $model->content = fbt($tableCode, $model->id, 'content', $model->content);

        return $model;
    }
}
