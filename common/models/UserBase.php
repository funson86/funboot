<?php
namespace common\models;

use common\models\base\Message;
use common\models\base\Profile;
use common\models\base\UserRole;
use Identicon\Identicon;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Message[] $messages
 * @property Message[] $message0
 * @property UserRole[] $userRoles
 * @property Store[] $stores
 * @property Store $store
 */
class UserBase extends BaseModel implements IdentityInterface
{
    const SEX_UNKNOWN = 0;
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    /**
     * @var array 角色
     */
    public $roles = [];

    public $password;
    public $repassword;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // 使用父类中的default场景
        return array_merge(parent::scenarios(), [
            'backend-store-edit' => ['username', 'password'],
            'backend-store-reset' => ['password'],
        ]);
    }

    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        // 删除一些包含敏感信息的字段
        unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'roles' => Yii::t('app', 'Role'),
            'password' => Yii::t('app', 'Password'),
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'token' => Yii::t('app', 'Token'),
            'access_token' => Yii::t('app', 'Access Token'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'verification_token' => Yii::t('app', 'Verification Token'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'auth_role' => Yii::t('app', 'Auth Role'),
            'name' => Yii::t('app', 'Name'),
            'avatar' => Yii::t('app', 'Avatar'),
            'brief' => Yii::t('app', 'Brief'),
            'sex' => Yii::t('app', 'Sex'),
            'area' => Yii::t('app', 'Area'),
            'province_id' => Yii::t('app', 'Province ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'address' => Yii::t('app', 'Address'),
            'birthday' => Yii::t('app', 'Birthday'),
            'point' => Yii::t('app', 'Point'),
            'balance' => Yii::t('app', 'Balance'),
            'remark' => Yii::t('app', 'Remark'),
            'last_login_at' => Yii::t('app', 'Last Login At'),
            'last_login_ip' => Yii::t('app', 'Last Login Ip'),
            'last_paid_at' => Yii::t('app', 'Last Paid At'),
            'last_paid_ip' => Yii::t('app', 'Last Paid Ip'),
            'consume_count' => Yii::t('app', 'Consume Count'),
            'consume_amount' => Yii::t('app', 'Consume Amount'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage0()
    {
        return $this->hasMany(Message::className(), ['from_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStores()
    {
        return $this->hasMany(Store::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'id']);
    }

    /**
     * return label or labels array
     *
     * @param null $id
     * @param bool $flip
     * @return array|mixed
     */
    public static function getSexLabels($id = null, $all = false, $flip = false)
    {
        $data = [
            self::SEX_UNKNOWN => Yii::t('cons', 'SEX_UNKNOWN'),
            self::SEX_MALE => Yii::t('cons', 'SEX_MALE'),
            self::SEX_FEMALE => Yii::t('cons', 'SEX_FEMALE'),
        ];

        $all && $data += [];

        $flip && $data = array_flip($data);

        return !is_null($id) ? ($data[$id] ?? $id) : $data;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by token
     *
     * @param string $token
     * @return static|null
     */
    public static function findByToken($token)
    {
        return $token ? static::findOne(['token' => $token]) : null;
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmailAndStoreId($email, $storeId)
    {
        return static::findOne(['email' => $email, 'store_id' => $storeId]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = '';
    }

    /**
     * @param $roleId
     * @return array|UserRole|ActiveRecord
     * @throws \yii\base\InvalidConfigException
     */
    public function addRole($roleId, $storeId = null)
    {
        $model = UserRole::find()->where(['user_id' => $this->id, 'role_id' => $roleId])->one();
        if (!$model) {
            $model = new UserRole();
            $model->store_id = $storeId ?? $this->store_id;
            $model->user_id = $this->id;
            $model->role_id = $roleId;
            if (!$model->save()) {
                Yii::$app->logSystem->db($model->errors);
                return null;
            }
        }

        return $model;
    }

    public function getMixedAvatar($size = 50)
    {
        if ($this->avatar) {
            return $this->avatar;
        }
        return (new Identicon())->getImageDataUri($this->email, $size);
    }

    public function isBbsAdmin()
    {
        $userRoles = $this->getUserRoles()->all();
        foreach ($userRoles as $role) {
            if (in_array($role->role_id, Yii::$app->params['bbs']['adminRoleIds'])) {
                return true;
            }
        }

        return false;
    }
}
