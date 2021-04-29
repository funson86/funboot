<?php

namespace backend\modules\cms\controllers;

use common\models\base\Lang;
use common\models\cms\Page;
use Yii;
use common\models\cms\Catalog;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Catalog
 *
 * Class CatalogController
 * @package backend\modules\cms\controllers
 */
class CatalogController extends BaseController
{
    protected $style = 2;

    /**
      * @var Catalog
      */
    public $modelClass = Catalog::class;

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

    /**
     * 编辑/创建
     *
     * @return mixed
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);
        $this->beforeEdit($id, $model);

        // var_dump(Catalog::find()->where(['id' => $id])->with('languages')->one());
        //Yii::$app->cacheSystem->refreshLang($this->modelClass::getTableCode(), $id);
        //var_dump(Yii::$app->cacheSystem->getLang($this->modelClass::getTableCode(), $id, 'name', 'zh_CN'));
        var_dump(fbt($this->modelClass::getTableCode(), $id, 'brief', 'zh_CN'));

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post();

                //vd(Yii::$app->request->post());die();
                if ($model->save()) {
                    if (isset($post['Lang'])) {
                        foreach ($post['Lang'] as $field => $item) {
                            foreach ($post['Lang'][$field] as $target => $content) {
                                //翻译源语言和目标语言一致则忽略
                                if ($this->store->lang_source == $target) {
                                    continue;
                                }
                                $lang = Lang::find()->where(['store_id' => $this->getStoreId(), 'table_code' => $this->modelClass::getTableCode(), 'target_id' => $model->id, 'target' => $target, 'name' => $field])->one();
                                if (!$lang) {
                                    $lang = new Lang();
                                    $lang->store_id = $this->getStoreId();
                                    $lang->table_code = $this->modelClass::getTableCode();
                                    $lang->name = $field;
                                    $lang->source = $this->store->lang_source;
                                    $lang->target = $target;
                                    $lang->target_id = $model->id;
                                }
                                $lang->content = $content;
                                $lang->save();
                            }
                        }
                    }
                    $this->afterEdit($id, $model);
                    return $this->redirectSuccess(['index']);
                } else {
                    Yii::$app->logSystem->db($model->errors);
                }
            }
        }

        $mapLangContent = [];
        $langItems = Lang::find()
            ->where(['store_id' => $this->getStoreId(), 'table_code' => $this->modelClass::getTableCode()])
            ->andFilterWhere(['target_id' => $id])
            ->orderBy(['name' => SORT_ASC])
            ->all();
        foreach ($langItems as $langItem) {
            $mapLangContent[$langItem->name . '|' . $langItem->target] = $langItem->content;
        }

        $lang = [];
        foreach (Lang::getLanguageCode($this->store->lang_frontend, false, false, true) as $target) {
            //翻译源语言和目标语言一致则忽略
            if ($this->store->lang_source == $target) {
                continue;
            }

            foreach ($this->modelClass::getLangFieldType() as $name => $type) {
                !$lang[$name] && $lang[$name] = [];
                $lang[$name][$target] = $mapLangContent[$name . '|' . $target] ?? '';
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'lang' => $lang,
        ]);
    }

    protected function beforeEdit($id = null, $model = null)
    {
        $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);
    }

    protected function beforeDeleteModel($id, $soft = false, $tree = false)
    {
        if (!$soft) {
            Page::deleteAll(['catalog_id' => $id]);
        }
    }
}
