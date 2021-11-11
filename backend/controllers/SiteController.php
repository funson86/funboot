<?php
namespace backend\controllers;

use common\helpers\ArrayHelper;
use common\helpers\CommonHelper;
use common\helpers\DateHelper;
use common\helpers\EchartsHelper;
use common\helpers\IdHelper;
use common\models\base\Log;
use common\models\forms\ChangePasswordForm;
use common\models\pay\Payment;
use common\models\Store;
use common\models\User;
use Da\QrCode\QrCode;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\components\controller\BaseController;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'login-backend', 'error', 'captcha', 'set-language', 'qrcode', 'mail-audit'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'info', 'log', 'change-password', 'me', 'clear-cache', 'stat', 'color'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 6, // 最大显示个数
                'minLength' => 6, // 最少显示个数
                'padding' => 5, // 间距
                'height' => 36, // 高度
                'width' => 100, // 宽度
                'offset' => 4, // 设置字符偏移量
                'backColor' => 0xffffff, // 背景颜色
                'foreColor' => 0x62a8ea, // 字体颜色
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        // 非管理员不能登录后台
        if (!Yii::$app->authSystem->isBackend()) {
            Yii::$app->logSystem->login(Yii::$app->user->identity->username ?? '' . ' ' . Yii::$app->user->id . ' with no auth to backend', null, true);
            Yii::$app->user->logout();
            return $this->redirect('/');
        }

        // 同一个入口不同帐号，跳转到他自己的域名后台
        $user = Yii::$app->user->identity;
        $store = CommonHelper::getStoreByHostName();
        if ($user->store_id != $store->id) {
            $userStore = CommonHelper::getStoreById($user->store_id);
            // 如果是子店铺，则是从总后台跳转，允许不同，临时使用。否则可能是总后台，不同帐号点跳转到对应的后台
            if ($userStore->parent_id == 0) {
                $user->token = substr(IdHelper::snowFlakeId(), 0, 8);
                if ($user->save(false)) {
                    $store = Store::findOne($user->store_id);
                    // 如果客户登录，Store已经非激活，用户无法登录。如果是super admin从后台登录允许
                    if (!Yii::$app->authSystem->isSuperAdmin() && $store->status != Store::STATUS_ACTIVE) {
                        Yii::$app->user->logout();
                        return $this->redirect(['site/login']);
                    } else {
                        // 同一个入口，跳转到不同的后台
                        return $this->redirect(CommonHelper::getHostPrefix($store->host_name) . '/backend/site/login-backend?token=' . $user->token);
                    }
                } else {
                    Yii::$app->logSystem->db($user->errors);
                    Yii::$app->user->logout();
                    return $this->redirect(['site/login']);
                }
            }
        }

        return $this->renderPartial('index');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionInfo()
    {
        $storeId = $this->isAdmin() ? null : $this->getStoreId();
        $logCount = Log::find()->filterWhere(['store_id' => $storeId])->count();
        $userCount = User::find()->filterWhere(['store_id' => $storeId])->count();

        $this->layout = 'main';
        return $this->render($this->action->id, [
            'userCount' => $userCount,
            'logCount' => $logCount,

        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->loginCaptchaRequired();

        // 如果是POST提交
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                Yii::$app->logSystem->login();

                // 如果Store已经非激活，用户无法登录
                if ($this->store->status != Store::STATUS_ACTIVE) {
                    $model->addError('password', Yii::t('app', 'Website is not active'));
                    Yii::$app->user->logout();
                } else {
                    // 非管理员不能登录后台
                    if (!Yii::$app->authSystem->isBackend()) {
                        Yii::$app->logSystem->login(Yii::$app->user->identity->username ?? '' . ' ' . Yii::$app->user->id . ' with no auth to backend', null, true);
                        Yii::$app->user->logout();
                        // 跳转到前台
                        return $this->redirect('/');
                    } else { // 同一个入口不同帐号，跳转到他自己的域名后台
                        $user = Yii::$app->user->identity;
                        $store = CommonHelper::getStoreByHostName();
                        if ($user->store_id != $store->id) {
                            $user->token = substr(IdHelper::snowFlakeId(), 0, 8);
                            if ($user->save(false)) {
                                $store = Store::findOne($user->store_id);
                                // 如果客户登录，Store已经非激活，用户无法登录。如果是super admin从后台登录允许
                                if (!Yii::$app->authSystem->isSuperAdmin() && $store->status != Store::STATUS_ACTIVE) {
                                    Yii::$app->user->logout();
                                    $model->addError('password', Yii::t('app', 'Website is not active'));
                                } else {
                                    return $this->redirect(CommonHelper::getHostPrefix($store->host_name) . '/backend/site/login-backend?token=' . $user->token);
                                }
                            } else {
                                Yii::$app->logSystem->db($user->errors);
                                Yii::$app->user->logout();
                                return $this->redirect(['/']);
                            }
                        } else {
                            return $this->redirect(['/']);
                        }
                    }
                }
            }

            Yii::$app->logSystem->login($model->attributes, null, true);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * 统计日志信息
     * @return mixed|string
     */
    public function actionLog()
    {
        $start = Yii::$app->session->get('oldLastLoginAt', (time() - 7*86400));

        $logErrorCount = Log::find()->where(['type' => Log::TYPE_ERROR])->andWhere('created_at > ' . $start)->count();
        $logLoginCount = Log::find()->where(['type' => Log::TYPE_LOGIN])->andWhere('created_at > ' . $start)->count();
        $logDbCount = Log::find()->where(['type' => Log::TYPE_DB])->andWhere('created_at > ' . $start)->count();

        return $this->success([
            'logErrorCount' => $logErrorCount,
            'logLoginCount' => $logLoginCount,
            'logDbCount' => $logDbCount,
            'logCount' => $logErrorCount + $logLoginCount + $logDbCount,
        ]);
    }

    /**
     * @return mixed|string
     */
    public function actionMe()
    {
        $model = User::findOne(Yii::$app->user->id);
        if (!$model) {
            return $this->redirectError();
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirectSuccess();
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * 修改密码
     * @return mixed|string
     */
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            Yii::$app->user->logout();
            return $this->redirectSuccess(['/']);
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionClearCache()
    {
        if (Yii::$app->authSystem->isAdmin()) {
            Yii::$app->cacheSystem->clearAllPermission();
            Yii::$app->cacheSystem->clearAllStore();
            Yii::$app->cacheSystem->clearAllSetting();
            Yii::$app->cacheSystem->clearAllDict();

            if (isset(Yii::$app->cacheSystemCms)) {
                Yii::$app->cacheSystemCms->clearCmsAllData();
            }
        } else {
            Yii::$app->cacheSystem->clearUserPermissionIds(Yii::$app->user->id);
            Yii::$app->cacheSystem->clearStoreSetting();
            Yii::$app->cacheSystem->refreshStoreLang();

            if (isset(Yii::$app->cacheSystemCms)) {
                Yii::$app->cacheSystemCms->clearStoreCatalogs();
                Yii::$app->cacheSystemCms->clearStorePages();
            }
        }

        Yii::$app->cache->flush();
        return $this->redirectSuccess();
    }

    public function actionStat($category = 'user', $type = 'last30Day')
    {
        $fields = [
            'count' => Yii::t('app', 'Count'),
            'price' => Yii::t('app', 'Price'),
        ];

        list($time, $format) = EchartsHelper::getFormatTime($type);
        return $this->success(EchartsHelper::lineOrBarInTime(function ($startTime, $endTime, $formatting) {
            $data = Log::find()
                ->select(['count(*) as count', 'sum(type) as price', "from_unixtime(created_at, '$formatting') as time"])
                //->andWhere(['>', 'status', StatusEnum::DISABLED])
                ->andWhere(['between', 'created_at', $startTime, $endTime])
                ->groupBy(['time'])
                ->asArray()
                ->all();

            foreach ($data as &$item) {
                $item['count'] = abs($item['count']);
            }

            return $data;
        }, $fields, $time, $format));
    }

    public function actionColor()
    {
        $this->layout = 'simple';

        $value = Yii::$app->request->get('value', '000000');
        strpos($value, '#') !== 0 && $value = '#' . $value;

        return $this->render($this->action->id, [
            'value' => $value,
        ]);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return Yii::$app->authSystem->isAdmin();
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return Yii::$app->authSystem->isSuperAdmin();
    }

    public function actionQrcode()
    {
        $width = intval(Yii::$app->request->get('width', 300));
        $width > 700 && $width = 700;

        $text = Yii::$app->request->get('text', CommonHelper::getStoreUrl($this->store, Yii::$app->params['storePlatformUrlPrefix']));
        $qrCode = (new QrCode($text))
            ->useEncoding('UTF-8')
            ->setSize($width);

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', $qrCode->getContentType());
        echo $qrCode->writeString();
    }

    /**
     * @return array|mixed
     */
    public function actionMailAudit()
    {
        $id = Yii::$app->request->get('id');
        $type = Yii::$app->request->get('type');
        $createdAt = Yii::$app->request->get('created_at');
        $shipmentName = Yii::$app->request->get('shipment_name');

        if (!$id) {
            return $this->htmlFailed(404);
        }

        if ($type == 'order') {
            $status = Yii::$app->request->get('status');
            $model = Order::find()->where(['id' => $id, 'created_at' => $createdAt])->one();
            if (!$model || $model->store_id != $this->getStoreId()) {
                return $this->htmlFailed(403);
            }

            if (!$status || !in_array(intval($status), array_keys(Order::getStatusLabels()))) {
                return $this->htmlFailed(422);
            }

            if (time() - $model->created_at > 3 * 3600) {
                return $this->htmlFailed(429);
            }

            $model->shipment_status = $model->status = intval($status);
            $shipmentName && $model->shipment_name = $shipmentName;
            if (!$model->save()) {
                return $this->htmlFailed();
            }

            return $this->htmlSuccess();
        } elseif ($type == 'payment') {
            $sn = Yii::$app->request->get('sn', null);

            $status = Yii::$app->request->get('status', null);
            if ($status) {
                $model = Payment::find()->where(['id' => $id, 'sn' => $sn, 'created_at' => $createdAt])->one();
                if (!$model || $model->store_id != $this->getStoreId()) {
                    return $this->htmlFailed(403);
                }

                if (!$status || !in_array(intval($status), array_keys(Payment::getStatusLabels()))) {
                    return $this->htmlFailed(422);
                }

                if (time() - $model->created_at > 3 * 3600) {
                    return $this->htmlFailed(429);
                }

                $model->status = intval($status);
                if (!$model->save()) {
                    return $this->htmlFailed();
                }
            }

            $storeStatus = Yii::$app->request->get('store_status', null);
            if (!is_null($storeStatus)) {
                $model = Payment::find()->where(['id' => $id, 'sn' => $sn, 'created_at' => $createdAt])->one();
                if (!$model || $model->store_id != $this->getStoreId()) {
                    return $this->htmlFailed(403);
                }

                $this->store->status = intval($storeStatus);
                if (!$this->store->save()) {
                    return $this->htmlFailed();
                }
            }

            return $this->htmlSuccess();
        }

    }

}
