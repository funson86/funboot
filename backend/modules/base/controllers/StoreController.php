<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use common\helpers\IdHelper;
use common\models\base\Role;
use common\models\User;
use Da\QrCode\QrCode;
use Yii;
use common\models\Store;
use common\models\ModelSearch;
use backend\controllers\BaseController;
use yii\helpers\FileHelper;

/**
 * Store
 *
 * Class StoreController
 * @package backend\modules\base\controllers
 */
class StoreController extends BaseController
{
    /**
      * @var Store
      */
    public $modelClass = Store::class;

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
    * 可编辑字段
    *
    * @var int
    */
   protected $exportFields = [
       'id' => 'text',
       'name' => 'text',
       'type' => 'select',
   ];

    /**
      * ajax编辑/创建
      *
      * @return mixed|string|\yii\web\Response
      * @throws \yii\base\ExitException
      */
    public function actionEditAjax()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        if ($id) {
            $user = User::findOne($model->user_id);
        } else {
            $user = new User(['scenario' => 'backend-store-edit']);
        }

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->user_id = Yii::$app->params['defaultUserId'];
            $model->language = ArrayHelper::arrayToInt($post['Store']['languages'] ?? []);
            $model->type = ArrayHelper::arrayToInt($post['Store']['types'] ?? []);
            $model->expired_at = strtotime($post['Store']['expiredTime']) + 86400 - 1;

            if ($model->save()) {
                $user->store_id = $model->id;
                if (strlen($post['User']['password']) > 0) {
                    $user->setPassword(trim($post['User']['password']));
                }

                if (!$user->save()) {
                    $model->delete();
                    Yii::$app->logSystem->db($user->errors);
                    $this->flashError($this->getError($user));
                }

                // 增加user为默认店铺角色
                $role = Role::getDefaultStoreRole();
                if ($role) {
                    $user->addRole($role->id, $model->id);
                }

                // 设置store的管理员
                $model->user_id = $user->id;
                $this->setDefaultData($model);
                if (!$model->save()) {
                    Yii::$app->logSystem->db($user->errors);
                    $this->redirectError($model);
                }

                Yii::$app->cacheSystem->clearAllStore();
                $this->generateHostFile();
                $this->redirectSuccess();
            } else {
                $this->redirectError($model);
            }
        }

        $model->expiredTime = date('Y-m-d', ($model->expired_at > 0 ? $model->expired_at : time() + 365 * 86400));
        $model->languages = ArrayHelper::intToArray($model->language, $this->modelClass::getLanguageLabels());
        $model->types = ArrayHelper::intToArray($model->type, $this->modelClass::getTypeLabels());
        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * 跳转登录
     *
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionLogin($id)
    {
        $model = $this->findModel($id, true);
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $user = $model->user_id > 0 ? User::findOne($model->user_id) : null;
        if ($user) {
            $user->token = substr(IdHelper::snowFlakeId(), 0, 8);
            if ($user->save()) {
                return $this->redirect(Yii::$app->params['httpProtocol'] . $model->host_name . '/backend/site/login-backend?token=' . $user->token);
            }
        }

        return $this->goBack();
    }

    /**
     * 重新生成配置文件
     *
     * @return mixed
     */
    public function actionEditConfig()
    {
        if ($this->generateHostFile()) {
            return $this->redirectSuccess();
        }

        return $this->redirectError();
    }

    /**
     * 生成二维码
     * @return mixed
     */
    public function actionEditQrcode()
    {
        $models = Store::find()->all();
        foreach ($models as $model) {
            if ($url = $this->generateQrcode($model)) {
                $model->qrcode = $url;
                $model->save();
            } else {
                $this->flashError($model->name . ' error');
            }
        }

        return $this->redirectSuccess();
    }

    /**
     * 设置默认数据
     *
     * @param $model
     * @return bool
     */
    protected function setDefaultData($model)
    {
        return true;
    }

    protected function generateHostFile()
    {
        $str = "<?php\nreturn [\n";
        $models = Store::find()->all();
        foreach ($models as $model) {
            if (strpos($model->host_name, '|') !== false) {
                $arr = explode('|', $model->host_name);
                foreach ($arr as $item) {
                    $str .= "    '" . $item . "' => '" . $model->route . "',\n";
                }
            } else {
                $str .= "    '" . $model->host_name . "' => '" . $model->route . "',\n";
            }
        }
        $str .= "];\n";

        if (!file_put_contents(Yii::getAlias('@frontend/runtime/host.php'), $str)) {
            Yii::$app->logSystem->db('Write host file failed: ' .Yii::getAlias('@frontend/runtime/host.php') . ' ' . $str);
            return false;
        }

        return true;
    }

    protected function generateQrcode($model)
    {
        $url = Yii::$app->params['httpProtocol'] . $model->host_name . ($model->parent_id > 0 ? '?store_id=' . $model->id : '');
        $qrCode = (new QrCode($url))
            ->useEncoding('UTF-8')
            ->setSize(700);

        if (!file_put_contents(Yii::getAlias('@static/resources/qrcode/' . $model->id . '.png'), $qrCode->writeString())) {
            Yii::$app->logSystem->db('Write host file failed: ' .Yii::getAlias('@frontend/runtime/host.php') . ' ' . $url);
            return false;
        }

        return Yii::$app->params['httpProtocol'] . $model->host_name . '/resources/qrcode/' . $model->id . '.png';
    }
}
