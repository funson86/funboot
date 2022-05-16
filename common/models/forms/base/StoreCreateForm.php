<?php
namespace common\models\forms\base;

use common\helpers\CommonHelper;
use common\models\base\Role;
use common\models\Store;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * Store create form
 */
class StoreCreateForm extends Model
{
    public $email;
    public $password;
    public $code;
    public $verifyCode;

    const KEY_FAILED = 'storeCreateFailed';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'code'], 'trim'],
            [['email', 'password', 'code'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'checkExist'],
            ['code', 'checkExistCode'],
            ['password', 'string', 'min' => 6],
            ['verifyCode', 'captcha', 'captchaAction' => 'site/captcha', 'on' => 'captchaRequired'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'code' => Yii::t('app', 'Code'),
            'verifyCode' => Yii::t('app', 'Verify Code'),
        ];
    }

    public function checkExist($attribute, $params)
    {
        $users = User::find()->where(['email' => $this->email, ])->all();
        if (count($users)) {
            $ids = ArrayHelper::getColumn($users, 'id');
            $store = Store::find()->where(['user_id' => $ids])->one();
            if ($store) {
                $this->addError($attribute, Yii::t('app', '{attribute} exist', ['attribute' => Yii::t('app', 'Email')]));
            }
        }
    }

    public function checkExistCode($attribute, $params)
    {
        if (Store::find()->where(['code' => $this->code])->one()) {
            $this->addError($attribute, Yii::t('app', '{attribute} exist', ['attribute' => Yii::t('app', 'Url')]));
        }
    }

    /**
     * create
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function create()
    {
        if ($this->validate()) {
            $store = new Store();
            $store->user_id = 1;
            $store->name = ucfirst(strtolower($this->code));
            $store->code = $this->code;
            $store->host_name = $this->code . '.' . Yii::$app->params['storePlatformDomain'];
            $store->route = Yii::$app->params['storePlatformRoute'];
            $store->expired_at = strtotime(date('Y-m-d', time())) + (Yii::$app->params['defaultStoreValidTime'] ?? (365 * 86400)) - 1;
            if (!$store->save()) {
                Yii::error($store->errors);
                Yii::$app->session->set(self::KEY_FAILED, Yii::$app->session->get(self::KEY_FAILED, 0) + 1);
                return false;
            }

            $user = new User();
            $user->username = str_replace('.', '_', str_replace('@', '_', $this->email)) . '_' . $store->id;
            $user->email = $this->email;
            $user->store_id = $store->id;
            $user->setPassword($this->password);

            $user->generateAuthKey();
            $user->generateEmailVerificationToken();

            $this->setDefaultUser($user);
            if (!$user->save()) {
                Yii::error($user->errors);
                $store->delete();
                Yii::$app->session->set(self::KEY_FAILED, Yii::$app->session->get(self::KEY_FAILED, 0) + 1);
                return false;
            }

            // 增加user为默认店铺角色
            $role = Role::getDefaultStoreRole();
            if ($role) {
                $user->addRole($role->id, $store->id);
            }

            $store->user_id = $user->id;
            $this->setDefaultStore($store);
            $store->save();
            $this->sendEmail($store, $user);
            return $user;
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($store, $user)
    {
        $content = CommonHelper::render(Yii::getAlias('@common/mail/emailStoreCreate-html.php'), [
            'store' => $store,
            'user' => $user,
        ], $this, Yii::getAlias('@common/mail/layouts/html.php'));

        $store = Yii::$app->storeSystem->get();
        Yii::$app->mailSystem->send($this->email, Yii::t('app', 'Say hello to ') . $store->host_name, $content);
    }

    /**
     * 验证码显示判断
     */
    public function checkCaptchaRequired()
    {
        if (Yii::$app->session->get(self::KEY_FAILED) >= $this->getAttempts()) {
            $this->setScenario("captchaRequired");
        }
    }

    protected function getAttempts()
    {
        return Yii::$app->params['storeCreateAttempts'] ?? 3;
    }

    protected function setDefaultStore(Store $store)
    {
        return true;
    }

    protected function setDefaultUser(User $user)
    {
        return true;
    }
}
