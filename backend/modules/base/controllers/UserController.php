<?php

namespace backend\modules\base\controllers;

use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\helpers\IdHelper;
use common\models\base\Role;
use common\models\base\UserRole;
use common\models\Store;
use Yii;
use common\models\User;
use common\models\ModelSearch;
use backend\controllers\BaseController;

/**
* User
*
* Class UserController
* @package backend\modules\base\controllers
*/
class UserController extends BaseController
{
    /**
    * @var User
    */
    public $modelClass = User::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['username', 'email', 'brief'];

    /**
     * 可编辑字段
     *
     * @var int
     */
    protected $editAjaxFields = ['name', 'sort', 'remark'];

    /**
     * 导入导出字段
     *
     * @var int
     */
    protected $exportFields = [
        //'id' => 'text',
        'email' => 'text',
        'last_paid_at' => 'date',
        'consume_count' => 'text',
        'consume_amount' => 'text',
        'created_at' => 'date',
    ];

    /**
     * 不显示管理员帐号
     * @param $params
     * @return bool|void
     */
    protected function filterParams(&$params)
    {
        if (!$this->isAdmin()) {
            $params['ModelSearch']['id'] = '>' . $this->store->user_id;
        }
    }

    /**
     * 编辑/创建
     *
     * @return mixed
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);

        $allRoles = [];
        $userRole = UserRole::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['role_id' => SORT_ASC])->one();
        if ($userRole) {
            //默认前端ID，然后按照组别进行区分，只能选择比自己组别小的角色，比如管理员只能设置商家、
            $roleId = $userRole->id;
            $minRoleId = Yii::$app->authSystem->maxStoreRoleId + 1;
            $roleId <= Yii::$app->authSystem->maxAdminRoleId && $minRoleId = Yii::$app->authSystem->maxAdminRoleId + 1;
            $roleId <= Yii::$app->authSystem->maxSuperAdminRoleId && $minRoleId = Yii::$app->authSystem->maxSuperAdminRoleId + 1;

            $allRoles = ArrayHelper::map(Role::find()->where(['status' => Role::STATUS_ACTIVE])->andWhere(['>=', 'id', $minRoleId])->asArray()->all(), 'id', 'name');
        } elseif ($this->isSuperAdmin()) {
            $allRoles = ArrayHelper::map(Role::find()->where(['status' => Role::STATUS_ACTIVE])->asArray()->all(), 'id', 'name');
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if (isset($model->id)) {
                    UserRole::deleteAll(['user_id' => $model->id]);
                }

                if ($model->save()) {
                    // 保存用户角色关系
                    $roles = Yii::$app->request->post($model->formName())['roles'] ?? [];
                    if (is_array($roles) && count($roles) > 0) {
                        foreach ($roles as $roleId) {
                            $userRole = new UserRole();
                            $userRole->user_id = $model->id;
                            $userRole->role_id = $roleId;
                            if (!$userRole->save()) {
                                Yii::$app->logSystem->db($userRole->errors);
                            }
                        }
                    }

                    Yii::$app->cacheSystem->clearUserRoleIds($model->id);
                    Yii::$app->cacheSystem->clearUserPermissionIds($model->id);
                    return $this->redirectSuccess(['index']);
                } else {
                    Yii::error($model->errors);
                    $this->flashError($this->getError($model));
                }
            }
        }

        $model->roles = ArrayHelper::getColumn(UserRole::find()->filterWhere(['user_id' => $id])->asArray()->all(), 'role_id');

        return $this->render($this->action->id, [
            'model' => $model,
            'allRoles' => $allRoles,
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
    public function actionLogin()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $model = $this->findModel($id, true);
        if (!$model) {
            return $this->redirectError(Yii::t('app', 'Invalid id'));
        }

        $store = $model->store_id > 0 ? Store::findOne($model->store_id) : null;
        if ($model) {
            $model->token = substr(IdHelper::snowFlakeId(), 0, 8);
            if ($model->save()) {
                return $this->redirect(CommonHelper::getHostPrefix($store->host_name) . '/site/login-backend?token=' . $model->token);
            }
        }

        return $this->goBack();
    }

}
