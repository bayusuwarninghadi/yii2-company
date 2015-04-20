<?php
namespace common\models;

use common\modules\RemoveAssetHelper;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $status
 * @property integer $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Cart[] $carts
 * @property Shipping[] $shippings
 * @property Transaction[] $transactions
 * @property UserComment[] $userComments
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * STATUS_INACTIVE
     */
    const STATUS_INACTIVE = 0;

    /**
     * STATUS_ACTIVE
     */
    const STATUS_ACTIVE = 10;

    /**
     * ROLE_SUPER_ADMIN
     */
    const ROLE_SUPER_ADMIN = 1;

    /**
     * ROLE_ADMIN
     */
    const ROLE_ADMIN = 2;

    /**
     * ROLE_USER
     */
    const ROLE_USER = 3;

    /**
     * @var UploadedFile|Null file attribute
     */
    public $image;

    /**
     * @var string $password
     */
    public $password;

    public $disclaimer = 0;

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getRoleAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::ROLE_USER => 'User',
                static::ROLE_ADMIN => 'Admin',
            ]
            : [
                static::ROLE_USER,
                static::ROLE_ADMIN,
            ];
        return $return;
    }

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getStatusAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::STATUS_ACTIVE => 'Active',
                static::STATUS_INACTIVE => 'Inactive',
            ]
            : [
                static::STATUS_ACTIVE,
                static::STATUS_INACTIVE,
            ];
        return $return;
    }

    /**
     * beforeDelete
     * @return bool
     */
    public function beforeDelete()
    {

        if (parent::beforeDelete()) {
            /*
             * remove image asset before deleting
             */
            RemoveAssetHelper::removeDirectory(Yii::$app->getBasePath() . '/../frontend/web/images/user/' . $this->id);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'image',
                'file',
                'extensions' => 'gif, jpg, png',
                'mimeTypes' => 'image/jpeg, image/png',
                'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
                'tooBig' => Yii::t('yii', 'The file "{file}" is too big. Its size cannot exceed ' . Yii::$app->params['maxFileUploadSize'] . ' Mb')
            ],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],

            [['status', 'created_at', 'updated_at'], 'integer'],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key', 'phone'], 'string', 'max' => 32],

            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['status', 'in', 'range' => static::getStatusAsArray(false)],

            ['role', 'default', 'value' => static::ROLE_USER],
            ['role', 'in', 'range' => static::getRoleAsArray(false)],

            ['password', $this->isNewRecord ? 'required' : 'string'],
            ['password', 'string', 'min' => 6],
            [
                'disclaimer',
                'required',
                'requiredValue' => 1,
                'message' => 'You must agree to our disclaimer'
            ]

        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
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
        return static::findOne(['username' => $username, 'status' => static::STATUS_ACTIVE]);
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
            'status' => static::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
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
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippings()
    {
        return $this->hasMany(Shipping::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserComments()
    {
        return $this->hasMany(UserComment::className(), ['user_id' => 'id']);
    }
}
