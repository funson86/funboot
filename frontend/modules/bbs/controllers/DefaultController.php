<?php

namespace frontend\modules\bbs\controllers;

use common\helpers\ArrayHelper;
use common\models\base\Stuff;
use common\models\bbs\Node;
use common\models\bbs\Topic;
use common\models\forms\LoginEmailForm;
use frontend\models\bbs\SignupEmailForm;
use common\models\LoginForm;
use common\models\ModelSearch;
use frontend\models\PasswordResetRequestForm;
use frontend\models\bbs\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;

/**
 * Default controller for the `bbs` module
 */
class DefaultController extends BaseController
{
    public $likeAttributes = ['name'];

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ModelSearch([
            'model' => Topic::class,
            'scenario' => 'default',
            'likeAttributes' => $this->likeAttributes,
            'defaultOrder' => [
                'status' => SORT_ASC,
                'sort' => SORT_ASC,
                'id' => SORT_DESC,
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        // 管理员级别才能查看所有数据，其他只能查看本store数据
        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['store_id'] = $this->getStoreId();
        if (!$this->isManager()) {
            $params['ModelSearch']['status'] = Topic::STATUS_ACTIVE;
        } else {
            $params['ModelSearch']['status'] = [Topic::STATUS_ACTIVE, Topic::STATUS_INACTIVE];
        }

        // 判断节点
        $listChildren = [];
        if ($nodeId = Yii::$app->request->get('id')) {
            $node = Node::find()->where(['id' => $nodeId, 'store_id' => $this->getStoreId()])->one();
            if ($node) {
                $nodeIds = ArrayHelper::getChildrenIds($nodeId, Node::find()->select(['id', 'parent_id'])->asArray()->all());
                $params['ModelSearch']['node_id'] = $nodeIds;
            }

            $nodes = ArrayHelper::mapIdData(Yii::$app->cacheSystemBbs->getStoreNode());
            $listChildren = ArrayHelper::getRootSub2($nodeId, Yii::$app->cacheSystemBbs->getStoreNode($this->getStoreId(), null, false, true), true);
        } elseif (isset($params['ModelSearch']['tag_id']) && $params['ModelSearch']['tag_id'] > 0) {
            $listChildren = [];
        } else {
            $listChildren = Yii::$app->params['bbs']['indexNodeChildren'];
        }
        // var_dump($listChildren);die();

        $dataProvider = $searchModel->search($params);

        // 排序
        $sort = $dataProvider->getSort();
        $sort->attributes['id']['asc'] = ['status' => SORT_ASC, 'id' => SORT_DESC];
        $sort->attributes['like']['asc'] = ['status' => SORT_ASC, 'like' => SORT_DESC, 'id' => SORT_DESC];
        $sort->attributes['click']['asc'] = ['status' => SORT_ASC, 'click' => SORT_DESC, 'id' => SORT_DESC];

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'listChildren' => $listChildren,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginEmailForm();
        $model->checkCaptchaRequired();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for registration. Please check your inbox for verification email.'));
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword()
    {
        $token = Yii::$app->request->get('token');
        if (!$token) {
            return $this->goBack();
        }

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'New password saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail()
    {
        $token = Yii::$app->request->get('token');
        if (!$token) {
            return $this->goBack();
        }

        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Your email has been confirmed!'));
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to verify your account with provided token.'));
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to resend verification email for the provided email address.'));
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionYellowPage()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render($this->action->id, [
            'model' => $model
        ]);
    }
}
