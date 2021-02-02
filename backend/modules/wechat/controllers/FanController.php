<?php

namespace backend\modules\wechat\controllers;

use common\services\wechat\FanService;
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

    public function actionEditAjaxRefreshSelect()
    {
        $openids = Yii::$app->request->post('openids');
        if (empty($openids)) {
            return $this->success();
        }

        Fan::updateAll(['subscribe' => 0], ['store_id' => $this->getStoreId(), 'openid' => $openids]);

        foreach ($openids as $openid) {
            FanService::refreshInfo($openid);
        }

        return $this->success();
    }

    public function actionEditAjaxRefreshAll()
    {
        Fan::updateAll(['subscribe' => 0], ['store_id' => $this->getStoreId()]);

        list($total, $count, $nextOpenid) = FanService::refreshAll();

        while ($count > 0) {
            list($total, $count, $nextOpenid) = FanService::refreshAll();
        }

        return $this->success();
    }
}
