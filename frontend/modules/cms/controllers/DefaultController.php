<?php

namespace frontend\modules\cms\controllers;

use common\components\enums\YesNo;
use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\models\cms\Catalog;
use common\models\cms\Page;
use common\models\Store;
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
        $this->prefixStatic = '/resources/cms/' . $this->theme;
        $this->isMobile = CommonHelper::isMobile();

        //menu
        $this->allCatalog = Catalog::find()->where([
            'store_id' => $store->id,
        ])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->all();

        foreach ($this->allCatalog as $item) {
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

            $this->banner = $this->getCatalogBanner($catalogId);
        } elseif ($this->action->id == 'page') {
            $id = Yii::$app->request->get('id');
            $id && $this->model = Page::findOne($id);
            $this->model && $catalogId = $this->model->catalog_id;

            $bannerName = $this->isMobile ? 'banner_h5' : 'banner';
            $this->banner = !empty($this->model->$bannerName) ? $this->model->$bannerName : $this->getCatalogBanner($catalogId);
        } elseif ($this->action->id == 'index') {
            $this->banner = $this->getStoreBanner(true);
        }
        $rootCatalogId = $catalogId ? ArrayHelper::getRootId($catalogId, $this->allCatalog) : 0;

        $home = ['url' => Yii::$app->getUrlManager()->createUrl(['/']), 'name' => Yii::t('app', 'Home'), 'active' => ($this->action->id == 'index')];
        $this->mainMenu[0] = $this->mainMenu2[0] = $home;

        foreach ($this->allShowCatalog as $catalog) {
            $item = ['id' => $catalog['id'], 'name' => $catalog['name'], 'active'=> ($catalog['id'] == $rootCatalogId)];
            if ($catalog['type'] == 'link') {// redirect to other site
                $item['url'] = $catalog['redirect_url'];
            } else {
                $item['url'] = Yii::$app->getUrlManager()->createUrl(['cms/default/' . $catalog['type'] . '/', 'id' => $catalog['id']]);
            }

            !empty($item) && array_push($this->mainMenu, $item);
        }

        // sub menu 2
        $allCatalog2 = ArrayHelper::getTreeIdLabel(0, $this->allShowCatalog, '');
        foreach ($allCatalog2 as $catalog) {
            $item = ['id' => $catalog['id'], 'name' => $catalog['name'], 'active' => ($catalog['id'] == $rootCatalogId)];
            if ($catalog['type'] == 'link') {// redirect to other site
                $item['url'] = $catalog['link'];
            } else {
                $item['url'] = Yii::$app->getUrlManager()->createUrl(['cms/default/' . $catalog['type'] . '/', 'id' => $catalog['id']]);
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

        // 公司简介
        $about = Catalog::find()->where(['store_id' => $this->store->id, 'type' => Catalog::TYPE_MENU])->orderBy(['id' => SORT_ASC])->one();

        $two = Catalog::find()->where(['store_id' => $this->store->id, 'type' => Catalog::TYPE_LIST, 'parent_id' => 0])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->limit(2)->asArray()->all();
        if (isset($two[0]['id'])) {
            $newsModel = $two[0];
            $newsList = Page::find()->where(['store_id' => $this->store->id, 'catalog_id' => $two[0]['id']])->orderBy(['sort' => SORT_ASC, 'id' => SORT_DESC])->limit(20)->all();
        }
        if (isset($two[1]['id'])) {
            $productModel = $two[1];
            $productList = Page::find()->where(['store_id' => $this->store->id, 'catalog_id' => $two[1]['id']])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])->limit(20)->all();
        }

        return $this->render($store->settings['cms_template'] ?: $this->action->id, [
            'store' => $this->store,
            'banners' => $this->getStoreBanner(true),
            'about' => $about,
            'newsModel' => $newsModel ? $newsModel : [],
            'newsList' => is_array($newsList) ? $newsList : [],
            'productModel' => isset($productModel) ? $productModel : [],
            'productList' => is_array($productList) ? $productList : [],
        ]);

    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionList($id)
    {
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

        // 将大分类下的所有子分类中click高的排序
        $rootId = ArrayHelper::getRootId($id, $this->allCatalog);
        $ids = ArrayHelper::getChildrenIds($rootId, $this->allCatalog);
        $relates = Page::find()
            ->where(['status' => Page::STATUS_ACTIVE, 'catalog_id' => $ids,])
            ->orderBy(['click' => SORT_DESC, 'id' => SORT_ASC])
            ->limit(5)
            ->all();

        return $this->render($this->model->template ?: $this->action->id, [
            'model' => $this->model,
            'models' => $models,
            'pagination' => $pagination,
            'store' => $this->store,
            'relates' => $relates,
        ]);
    }

    public function actionMenu($id)
    {
        if (!$this->model || $this->model->store_id != $this->store->id) {
            return $this->goHome();
        }

        return $this->render($this->model->template ?: $this->action->id, [
            'model' => $this->model,
            'store' => $this->store,
        ]);
    }

    public function actionPage($id)
    {
        if (!$this->model || $this->model->store_id != $this->store->id) {
            return $this->goHome();
        }

        // 如果是跳转到其他页面
        if (strlen($this->model->redirect_url) > 5) {
            return $this->redirect($this->model->redirect_url);
        }

        $prev = Page::find()->where('id < ' . $id)->andWhere(['catalog_id' => $this->model->catalog_id, 'status' => Page::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC])->one();
        $next = Page::find()->where('id > ' . $id)->andWhere(['catalog_id' => $this->model->catalog_id, 'status' => Page::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->one();

        $rootId = ArrayHelper::getRootId($this->model->catalog_id, $this->allCatalog);
        $ids = ArrayHelper::getChildrenIds($rootId, $this->allCatalog);
        $relates = Page::find()
            ->where(['status' => Page::STATUS_ACTIVE, 'catalog_id' => $ids,])
            ->andWhere(['<>', 'id', $id])
            ->orderBy(['click' => SORT_DESC, 'id' => SORT_ASC])
            ->limit(5)
            ->all();

        $template = isset($this->mapAllCatalog[$this->model->catalog_id]['template_page']) ? $this->mapAllCatalog[$this->model->catalog_id]['template_page'] : 'page';
        return $this->render($template ?: $this->action->id, [
            'model' => $this->model,
            'store' => $this->store,
            'prev' => $prev,
            'next' => $next,
            'relates' => $relates,
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
        $bannerData =$this->store->settings[$bannerName];
        $banners = is_array($bannerData) ? $bannerData : json_decode($bannerData, true);

        if (!$banners || empty($banners)) {
            $h5 = CommonHelper::isMobile() ? 'h5-' : '';
            $banners = [$this->prefixStatic . '/img/banner-' . $h5 . '01.jpg', $this->prefixStatic . '/img/banner-' . $h5 . '02.jpg', ];
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
}
