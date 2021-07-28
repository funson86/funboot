<?php

namespace frontend\modules\pay\controllers;

use common\components\mailer\SmtpMailer;
use common\helpers\CommonHelper;
use common\helpers\IdHelper;
use common\helpers\Url;
use common\helpers\ValidHelper;
use common\models\ModelSearch;
use common\models\Store;
use frontend\controllers\BaseController;
use Yii;
use common\models\pay\Payment;

/**
 * Default controller for the `pay` module
 */
class DefaultController extends BaseController
{
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render($this->action->id, []);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionPay()
    {
        $model = new Payment();
        $model->id = IdHelper::snowFlakeId();
        $model->store_id = $this->getStoreId();
        $store = $this->store;

        $model->captchaRequired();
        if (Yii::$app->request->isPost) {
            if ($store->status != Store::STATUS_ACTIVE) {
                $this->flashError(Yii::t('app', 'Closed Yet, please try it later'));
            } else {
                Yii::$app->session->set('paymentSubmit', Yii::$app->session->get('paymentSubmit', 0) + 1);

                if ($model->load(Yii::$app->request->post())) {
                    $model->sn = substr(IdHelper::snowFlakeId(), -4);
                    $model->money /= 100;
                    $model->status = Payment::STATUS_UNPAID;

                    if ($model->save()) {

                        $this->sendMail($model);

                        return $this->redirectSuccess(['/pay/default/checkout', 'id' => $model->id]);
                    }
                }
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    protected function sendMail(Payment $model)
    {
        $store = $this->store;
        Yii::$app->urlManager->setBaseUrl("https://" . $store->host_name . '/backend');
        $urlParam = ['/site/mail-audit', 'type' => 'payment', 'id' => $model->id, 'created_at' => $model->created_at, 'sn' => $model->sn];
        $buttons = [
            'paid' => ['url' => Url::toWithoutCheck(array_merge($urlParam, ['status' => Payment::STATUS_PAID])), 'label' => Yii::t('app', '支付成功并加入名单'), 'color' => '#28a745'],
            'paid_funpay' => ['url' => Url::toWithoutCheck(array_merge($urlParam, ['status' => Payment::STATUS_PAID, 'type' => 'funpay'])), 'label' => Yii::t('app', '支付成功并发送FunPay'), 'color' => '#91c444'],
            'paid_funboot' => ['url' => Url::toWithoutCheck(array_merge($urlParam, ['status' => Payment::STATUS_PAID, 'type' => 'funboot'])), 'label' => Yii::t('app', '支付成功并发送Funboot'), 'color' => '#17a2b8'],
            'paid_without_list' => ['url' => Url::toWithoutCheck(array_merge($urlParam, ['status' => Payment::STATUS_PAID_WITHOUT_LIST])), 'label' => Yii::t('app', '支付成功不加入名单'), 'color' => '#007bff'],
            'delete' => ['url' => Url::toWithoutCheck(array_merge($urlParam, ['status' => Payment::STATUS_DELETED])), 'label' => Yii::t('app', '删除订单'), 'color' => '#dc3545'],
            'close' => ['url' => Url::toWithoutCheck(array_merge($urlParam, ['store_status' => Store::STATUS_INACTIVE])), 'label' => Yii::t('app', '网站关闭'), 'color' => '#fd7e14'],
            'open' => ['url' => Url::toWithoutCheck(array_merge($urlParam, ['store_status' => Store::STATUS_ACTIVE])), 'label' => Yii::t('app', '网站开启'), 'color' => '#28a745'],
        ];

        $content = CommonHelper::render(Yii::getAlias('@common/mail/paymentNotification.php'), [
            'model' => $model,
            'store' => $store,
            'type' => 1,
            'buttons' => $buttons,
        ], $this, Yii::getAlias('@common/mail/layouts/html.php'));

        $subject = 'New payment ' . $model->money . ' from ' . $model->name . ' (' . $model->email . ')  by ' . $model->bank_code;

        $to = Yii::$app->params['funPay']['adminEmail'];
        $cc = [];
        ValidHelper::isEmail($model->email_exp) && array_push($cc, $model->email_exp);

        Yii::$app->urlManager->setBaseUrl('');

        return Yii::$app->mailSystem->send($to, $subject, $content, $cc);
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

        $explain = '';
        if ($model->bank_code == 'wechat') {
            if (CommonHelper::isWeixin()) {
                $explain = $this->explain('请长按二维码选择“识别图中二维码”进行支付');
            } elseif (CommonHelper::isMobile()) {
                $explain = $this->explain('请长按二维码保存图片至手机后，打开微信使用“扫一扫”，点击右上角“相册”选择刚保存的二维码进行支付');
            } else {
                $explain = $this->explain('<img alt="扫一扫标识" class="explain" id="explain" src="/resources/pay/bank/wechat/wechat-explain.png">');
            }
        } elseif ($model->bank_code == 'alipay') {
            $explain = $this->explain('<a href="https://mobile.alipay.com/index.htm" target="_blank">首次使用请下载手机支付宝</a>');
        }

        return $this->render($this->action->id, [
            'model' => $model,
            'explain' => $explain,
        ]);
    }

    protected function explain($text, $html = false)
    {
        if (!$html) {
            return '<p class="explain">' . $text . '</p>';
        }

        return $text;
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionQuery()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->error(404);
        }
        $model = Payment::findOne($id);
        if (!$model) {
            return $this->error(400);
        }

        return $this->success($model);
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
