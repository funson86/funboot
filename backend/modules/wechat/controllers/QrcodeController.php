<?php

namespace backend\modules\wechat\controllers;

use common\services\wechat\QrcodeService;
use Yii;
use common\models\wechat\Qrcode;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
 * Qrcode
 *
 * Class QrcodeController
 * @package backend\modules\wechat\controllers
 */
class QrcodeController extends BaseController
{
    /**
      * @var Qrcode
      */
    public $modelClass = Qrcode::class;

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

    public function actionEditAjax()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        // ajax 校验
        $this->activeFormValidate($model);
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $result = QrcodeService::create($model->type, $model->scene_str, $model);
            if (!$result) {
                $this->redirectError();
            }

            return $this->redirectSuccess();
        }

        return $this->renderAjax(Yii::$app->request->get('view') ?? $this->action->id, [
            'model' => $model,
        ]);
    }
}
