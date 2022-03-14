<?php

namespace frontend\modules\cms\controllers;

use common\components\enums\YesNo;
use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\models\cms\Catalog;
use common\models\cms\Page;
use frontend\helpers\Url;
use Yii;

/**
 * Class BaseController
 * @package frontend\modules\cms\controllers
 * @author funson86 <funson86@gmail.com>
 */
class BaseController extends \frontend\controllers\BaseController
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

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $store = CommonHelper::getStoreByHostName();
        if ((Yii::$app->params['cmsForceHostName'] ?? true) && $this->store != $store) {
            $store->settings = Yii::$app->settingSystem->getSettings($store->id);
            $this->store = $store;
            Yii::$app->storeSystem->set($store);
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
        if ($this->id == 'default' && in_array($this->action->id, ['list', 'menu'])) {
            $catalogId = Yii::$app->request->get('id');
            $catalogId && $this->model = Catalog::findOne($catalogId);
            $this->model->name = fbt(Catalog::getTableCode(), $this->model->id, 'name', $this->model->name);
            $this->model->brief = fbt(Catalog::getTableCode(), $this->model->id, 'brief', $this->model->brief);
            $this->model->content = fbt(Catalog::getTableCode(), $this->model->id, 'content', $this->model->content);

            $this->banner = $this->getCatalogBanner($catalogId);
        } elseif ($this->id == 'default' && $this->action->id == 'page') {
            $id = Yii::$app->request->get('id');
            $id && $this->model = Page::findOne($id);
            $this->model && $catalogId = $this->model->catalog_id;
            $this->model = $this->buildLang($this->model, Page::getTableCode());

            $bannerName = $this->isMobile ? 'banner_h5' : 'banner';
            $this->banner = !empty($this->model->$bannerName) ? $this->model->$bannerName : $this->getCatalogBanner($catalogId);
        } else {
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
