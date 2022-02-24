<?php

namespace frontend\modules\mall\controllers;

use common\models\forms\base\FeedbackForm;
use common\models\forms\LoginEmailForm;
use common\models\mall\Cart;
use common\models\mall\Product;
use common\models\ModelSearch;
use common\models\Store;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupEmailForm;
use frontend\models\VerifyEmailForm;
use InvalidArgumentException;
use Yii;
use yii\web\BadRequestHttpException;

/**
 * Default controller for the `mall` module
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
        /*if ($this->store->parent_id == 0) {
            return $this->actionIndexPlatform();
        }*/

        $productsNew = Product::find()->where(['store_id' => $this->getStoreId(), 'status' => Product::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC])->limit(4)->all();
        $productsHot = Product::find()->where(['store_id' => $this->getStoreId(), 'status' => Product::STATUS_ACTIVE])->orderBy(['sales' => SORT_DESC])->limit(4)->all();
        return $this->render($this->action->id, [
            'productsNew' => $productsNew,
            'productsHot' => $productsHot,
        ]);
    }

    /**
     * 支持平台类型  www.funmall.com/mall-yongchang
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndexPlatform()
    {
        $this->layout = 'main-platform';
        $searchModel = new ModelSearch([
            'model' => Store::class,
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
        $params['ModelSearch']['parent_id'] = $this->getStoreId();
        $params['ModelSearch']['status'] = Store::STATUS_ACTIVE;

        $listChildren = [];
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

    public function actionSetCurrency()
    {
        $currency = Yii::$app->request->get('currency', Yii::$app->settingSystem->getValue('mall_currency_default'));
        Yii::$app->session->set('currentCurrency', $currency);

        return $this->goBack();
    }

    public function actionSearch()
    {
        $keyword = Yii::$app->request->get('keyword');
        if (!$keyword) {
            return $this->goBack();
        }
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
        $oldSessionId = Yii::$app->session->id;

        $model = new LoginEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->afterLogin($oldSessionId);
            if (Yii::$app->request->get('returnUrl')) {
                return $this->redirect(Yii::$app->request->get('returnUrl'));
            }
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render($this->action->id, [
                'model' => $model,
            ]);
        }
    }

    protected function afterLogin($oldSessionId)
    {
        //保持购物车数据还在
        Cart::updateAll(['user_id' => Yii::$app->user->id, 'session_id' => Yii::$app->session->id], ['store_id' => $this->getStoreId(), 'session_id' => $oldSessionId]);
        //合并之前登录时选入购物车的
        Cart::updateAll(['session_id' => Yii::$app->session->id], ['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id]);

        // 合并重复的
        /** @var Cart[] $models */
        $models = Cart::find()->where(['store_id' => $this->getStoreId(), 'user_id' => Yii::$app->user->id])->all();
        /** @var Cart[] $map */
        $map = [];
        foreach ($models as $model) {
            $key = $model->product_id . '-' . $model->product_attribute_value;
            if (isset($map[$key])) {
                $exist = $map[$key];
                $exist->number += $model->number;
                $exist->save();
                $model->delete();
            } else {
                $map[$key] = $model;
            }
        }
        return true;
    }

    /**
     * Logs in a user.
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

    public function actionFeedback()
    {
        $model = new FeedbackForm();
        $model->checkCaptchaRequired();

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            $this->flashSuccess(Yii::t('app', 'Operate Successfully'));
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }
}
