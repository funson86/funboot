<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\helpers\IdHelper;
use common\models\base\Role;
use common\models\User;
use Da\QrCode\QrCode;
use Yii;
use common\models\Store;

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
    protected $pageSize = 25;
    /**
      * @var Store
      */
    public $modelClass = Store::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name', 'host_name', 'brief'];

   /**
    * 可编辑字段
    *
    * @var int
    */
   protected $editAjaxFields = ['name', 'sort', 'host_name', 'brief'];

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

   protected function filterParams(&$params)
   {
       (!isset($params['ModelSearch']['status']) || is_null($params['ModelSearch']['status'])) && $params['ModelSearch']['status'] = '>=' . $this->modelClass::STATUS_DELETED;

       if ($this->isAgent()) {
           $params['ModelSearch']['created_by'] = Yii::$app->user->id;
       }
   }

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
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->user_id = Yii::$app->params['defaultUserId'];
            $model->route = $post[$model->formName()]['route'] ?? Yii::$app->params['defaultRoute'];
            $model->language = ArrayHelper::arrayToInt($post[$model->formName()]['languages'] ?? []);
            $model->lang_backend = ArrayHelper::arrayToInt($post[$model->formName()]['langBackends'] ?? Yii::$app->params['defaultLangBackend'] ?? []);
            $model->lang_frontend = ArrayHelper::arrayToInt($post[$model->formName()]['langFrontends'] ?? Yii::$app->params['defaultLangFrontend'] ?? []);
            $model->lang_api = ArrayHelper::arrayToInt($post[$model->formName()]['langApis'] ?? Yii::$app->params['defaultLangApi'] ?? []);
            $model->type = ArrayHelper::arrayToInt($post[$model->formName()]['types'] ?? []);
            $model->expired_at = strtotime($post[$model->formName()]['expiredTime']) + 86400 - 1;
            $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);

            if ($model->save()) {
                $user->store_id = $model->id;
                if (strlen($post[$user->formName()]['password']) > 0) {
                    $user->setPassword(trim($post[$user->formName()]['password']));
                }

                if (!$user->save()) {
                    $model->delete();
                    Yii::$app->logSystem->db($user->errors);
                    return $this->redirectError($this->getError($user));
                }

                // 增加user为默认店铺角色
                $user->addRole(Yii::$app->params['defaultStoreRole'][$model->route] ?? Role::getDefaultStoreRoleId(), $model->id);

                // 设置store的管理员
                $model->user_id = $user->id;
                $this->setDefaultData($model);
                if (!$model->save()) {
                    Yii::$app->logSystem->db($user->errors);
                    return $this->redirectError($this->getError($model));
                }

                $this->clearCache();
                $this->generateHostFile();
                return $this->redirectSuccess();
            } else {
                return $this->redirectError($this->getError($model));
            }
        }

        $model->expiredTime = date('Y-m-d', ($model->expired_at > 0 ? $model->expired_at : time() + Yii::$app->params['defaultStoreExpiredTime']));
        $model->languages = ArrayHelper::intToArray($model->language, $this->modelClass::getLanguageLabels());
        $model->langBackends = ArrayHelper::intToArray($model->lang_backend, $this->modelClass::getLanguageLabels());
        $model->langFrontends = ArrayHelper::intToArray($model->lang_frontend, $this->modelClass::getLanguageLabels());
        $model->langApis = ArrayHelper::intToArray($model->lang_api, $this->modelClass::getLanguageLabels());
        $model->types = ArrayHelper::intToArray($model->type, $this->modelClass::getTypeLabels());
        $model->parent_id == 0 && $model->parent_id = Yii::$app->request->get('parent_id', 0);
        return $this->renderAjax(Yii::$app->request->get('view') ?? $this->action->id, [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEditModal()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        if (!$model) {
            return $this->goBack();
        }

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            isset($post[$model->formName()]['expiredTime']) && $model->expired_at = strtotime($post[$model->formName()]['expiredTime']) + 86400 - 1;
            isset($post[$model->formName()]['chains']) && $model->chain = json_encode($post[$model->formName()]['chains']);
            if (!$model->save()) {
                Yii::$app->logSystem->db($model->errors);
                return $this->redirectError($this->getError($model));
            } else {
                $this->clearCache();
                return $this->redirectSuccess();
            }
        }

        $model->expiredTime = date('Y-m-d', ($model->expired_at > 0 ? $model->expired_at : time() + Yii::$app->params['defaultStoreExpiredTime']));
        $model->chains = $model->chain ? json_decode($model->chain, true) : [];
        return $this->renderAjax(Yii::$app->request->get('view') ?? $this->action->id, [
            'model' => $model,
        ]);
    }

    protected function afterEditAjaxStatus($id = null, $model = null, $status = null)
    {
        $this->clearCache();
        return true;
    }

    /**
     * 跳转登录
     *
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionEditLogin()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $model = $this->findModel($id);
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $user = $model->user_id > 0 ? User::findOne($model->user_id) : null;
        if ($user) {
            $user->token = substr(IdHelper::snowFlakeId(), 0, 8);
            if ($user->save()) {
                return $this->redirect(CommonHelper::getHostPrefix($model->host_name) . '/backend/site/login-backend?token=' . $user->token);
            }
        }

        return $this->goBack();
    }

    /**
     * 跳转
     *
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionEditGo()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $model = $this->findModel($id);
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        return $this->redirect(CommonHelper::getHostPrefix($model->host_name));
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
        $hostNames = [];
        foreach ($models as $model) {
            $arr = explode('|', $model->host_name);
            foreach ($arr as $item) {
                !in_array($item, $hostNames) && $str .= "    '" . $item . "' => '" . $model->route . "',\n";
                array_push($hostNames, $item);
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
        $url = CommonHelper::getHostPrefix($model->host_name) . ($model->parent_id > 0 ? '?store_id=' . $model->id : '');
        $qrCode = (new QrCode($url))
            ->useEncoding('UTF-8')
            ->setSize(700);

        if (!file_put_contents(Yii::getAlias('@static/resources/qrcode/' . $model->id . '.png'), $qrCode->writeString())) {
            Yii::$app->logSystem->db('Write host file failed: ' .Yii::getAlias('@frontend/runtime/host.php') . ' ' . $url);
            return false;
        }

        return CommonHelper::getHostPrefix($model->host_name) . '/resources/qrcode/' . $model->id . '.png';
    }

    /**
     * 状态正常的变成维护状态
     * @return mixed
     */
    public function actionEditMaintainAll()
    {
        Store::updateAll(['status' => $this->modelClass::STATUS_MAINTENANCE], ['status' => $this->modelClass::STATUS_ACTIVE]);

        $this->clearCache();
        return $this->redirectSuccess();
    }

    /**
     * @return mixed
     */
    public function actionEditMaintainCancel()
    {
        Store::updateAll(['status' => $this->modelClass::STATUS_ACTIVE], ['status' => $this->modelClass::STATUS_MAINTENANCE]);

        $this->clearCache();
        return $this->redirectSuccess();
    }

    protected function clearCache()
    {
        Yii::$app->cacheSystem->clearStoreSetting();
        return Yii::$app->cacheSystem->clearAllStore();
    }
}
