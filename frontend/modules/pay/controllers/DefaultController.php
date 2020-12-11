<?php

namespace frontend\modules\pay\controllers;

use common\components\mailer\SmtpMailer;
use common\helpers\CommonHelper;
use common\helpers\IdHelper;
use common\helpers\ValidHelper;
use common\models\ModelSearch;
use common\models\Store;
use Yii;
use common\components\controller\BaseController;
use common\models\pay\Payment;

/**
 * Default controller for the `pay` module
 */
class DefaultController extends BaseController
{
    public function beforeAction($action)
    {
        $this->layout = 'main';
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'landing';
        $model = new Payment();

        if (Yii::$app->request->isPost) {
            var_dump(Yii::$app->request->post());
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionPay()
    {
        $model = new Payment();
        $model->store_id = $this->getStoreId();
        $store = Store::findOne($this->getStoreId());

        $model->captchaRequired();
        if (Yii::$app->request->isPost) {
            if ($store->status != Store::STATUS_ACTIVE) {
                $resultMsg = Yii::t('app', 'Closed Yet, please try it later');
            } else {
                Yii::$app->session->set('paymentSubmit', Yii::$app->session->get('paymentSubmit', 0) + 1);

                if ($model->load(Yii::$app->request->post())) {
                    $model->sn = substr(IdHelper::snowFlakeId(), -4);
                    $model->money /= 100;

                    if ($model->save()) {

                        $this->sendMail($model);

                        return $this->redirect(['/pay/default/checkout', 'id' => $model->id]);
                    }
                }
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'resultMsg' => $resultMsg ?? null,
        ]);
    }

    protected function sendMail(Payment $model)
    {
        $store = $this->store;
        Yii::$app->urlManager->setBaseUrl("https://" . $store->host_name . '/backend');
        $urlParam = ['site/mail-audit', 'type' => 'payment', 'id' => $model->id, 'created_at' => $model->created_at, 'sn' => $model->sn];
        $buttons = [
            'paid' => ['url' => Yii::$app->urlManager->createAbsoluteUrl(array_merge($urlParam, ['status' => Payment::STATUS_PAID])), 'label' => Yii::t('app', 'Paid'), 'color' => '#28a745'],
            'paid_funpay' => ['url' => Yii::$app->urlManager->createAbsoluteUrl(array_merge($urlParam, ['status' => Payment::STATUS_PAID, 'type' => 'funpay'])), 'label' => Yii::t('app', 'Paid'), 'color' => '#91c444'],
            'paid_funboot' => ['url' => Yii::$app->urlManager->createAbsoluteUrl(array_merge($urlParam, ['status' => Payment::STATUS_PAID, 'type' => 'funboot'])), 'label' => Yii::t('app', 'Paid'), 'color' => '#28a745'],
            'paid_without_list' => ['url' => Yii::$app->urlManager->createAbsoluteUrl(array_merge($urlParam, ['status' => Payment::STATUS_PAID_WITHOUT_LIST])), 'label' => Yii::t('app', 'Paid Without List'), 'color' => '#91c444'],
            'delete' => ['url' => Yii::$app->urlManager->createAbsoluteUrl(array_merge($urlParam, ['status' => Payment::STATUS_DELETED])), 'label' => Yii::t('app', 'Shipping'), 'color' => '#dc3545'],
            'close' => ['url' => Yii::$app->urlManager->createAbsoluteUrl(array_merge($urlParam, ['store_status' => Store::STATUS_INACTIVE])), 'label' => Yii::t('app', 'Done'), 'color' => '#ffc107'],
            'open' => ['url' => Yii::$app->urlManager->createAbsoluteUrl(array_merge($urlParam, ['store_status' => Store::STATUS_ACTIVE])), 'label' => Yii::t('app', 'Delivered'), 'color' => '#28a745'],
        ];

        $content = CommonHelper::render(Yii::getAlias('@common/mail/paymentNotification.php'), [
            'model' => $model,
            'store' => $store,
            'type' => 1,
            'buttons' => $buttons,
        ], $this, Yii::getAlias('@common/mail/layouts/html.php'));

        $subject = 'New payment ' . $model->money . ' from ' . $model->name . ' (' . $model->email . ')  by ' . $model->bank_code;

        $to = Yii::$app->params['FunPay']['adminEmail'];
        $cc = [];
        ValidHelper::isEmail($model->email_exp) && array_push($cc, $model->email_exp);

        $mailer = new SmtpMailer();
        return $mailer->send($to, null, $subject, $content, $cc);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCheckout()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }
        $model = Payment::findOne($id);
        if (!$model) {
            return $this->goBack();
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionList()
    {
        $searchModel = new ModelSearch([
            'model' => Payment::class,
            'scenario' => 'default',
            'likeAttributes' => ['name', 'remark', 'email'], // 模糊查询
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => Yii::$app->request->get('page_size', $this->pageSize),
        ]);

        $status = Yii::$app->request->get('status', Payment::STATUS_ACTIVE);
        ($status > Payment::STATUS_ACTIVE || $status < Payment::STATUS_EXPIRED) && $status = Payment::STATUS_ACTIVE;

        $params = Yii::$app->request->queryParams;
        $params['ModelSearch']['created_at'] = '>=' . (time() - 15 * 36500);
        $params['ModelSearch']['status'] = $status;
        $dataProvider = $searchModel->search($params);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
