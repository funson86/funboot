<?php

namespace backend\modules\bbs\controllers;

use Yii;
use common\models\bbs\Topic;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Topic
 *
 * Class TopicController
 * @package backend\modules\bbs\controllers
 */
class TopicController extends BaseController
{
    /**
      * @var Topic
      */
    public $modelClass = Topic::class;

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

    protected function beforeEdit($id = null, $model = null)
    {
        $model->format = Yii::$app->request->get('format', $model->format ?: $this->modelClass::FORMAT_HTML);
        if ($model->isNewRecord) {
            $model->user_id = Yii::$app->user->id;
            $model->username = Yii::$app->user->identity->username;
            $model->user_avatar = Yii::$app->user->identity->avatar ?: Yii::$app->user->identity->email;
            $model->last_comment_updated_at = time();
        }
    }
}
