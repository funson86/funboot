<?php

namespace backend\modules\wechat\controllers;

use common\helpers\ArrayHelper;
use common\models\wechat\Tag;
use common\services\wechat\FanService;
use EasyWeChat\Kernel\Messages\Text;
use Yii;
use common\models\wechat\Fan;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Fan
 *
 * Class FanController
 * @package backend\modules\wechat\controllers
 */
class FanController extends BaseController
{
    /**
      * @var Fan
      */
    public $modelClass = Fan::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name', 'nickname'];

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

    public function actionEditAjaxSyncSelect()
    {
        $openids = Yii::$app->request->post('openids');
        if (empty($openids)) {
            return $this->success();
        }

        Fan::updateAll(['subscribe' => 0], ['store_id' => $this->getStoreId(), 'openid' => $openids]);

        foreach ($openids as $openid) {
            FanService::syncInfo($openid);
        }

        return $this->success();
    }

    public function actionEditAjaxSyncAll()
    {
        Fan::updateAll(['subscribe' => 0], ['store_id' => $this->getStoreId()]);

        $result = FanService::syncAll();

        return $this->success($result);
    }

    public function actionEditAjaxTag()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $tag = Tag::find()->where(['store_id' => $this->storeId])->one();

        // ajax 校验
        $this->activeFormValidate($model);
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if (!empty($model->tagid_list)) {
                $tagIds = [];
                foreach ($model->tagid_list as $tagId) {
                    $tagId = intval($tagId);
                    Yii::$app->wechat->app->user_tag->tagUsers([$model->openid], $tagId);
                    array_push($tagIds, $tagId);
                }
                $model->tagid_list = $tagIds;
            }
            if (!$model->save()) {
                $this->redirectError($this->getError($model));
            }

            return $this->redirectSuccess();
        }

        return $this->renderAjax(Yii::$app->request->get('view') ?? $this->action->id, [
            'model' => $model,
            'tags' => ArrayHelper::map($tag->tags, 'id', 'name'),
        ]);
    }

    public function actionEditAjaxMessage()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        // ajax 校验
        $this->activeFormValidate($model);
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $message = new Text('hello');
            $result = Yii::$app->wechat->app->customer_service->message($message)->to($model->openid)->send();

            if ($msg = Yii::$app->wechat->conductError($result, false)) {
                return $this->redirectError($msg, null, true);
            }

            return $this->redirectSuccess();
        }

        return $this->renderAjax(Yii::$app->request->get('view') ?? $this->action->id, [
            'model' => $model,
        ]);
    }
}
