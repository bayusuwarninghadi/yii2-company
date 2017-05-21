<?php
namespace frontend\models;

use common\models\Pages;
use common\models\Setting;
use common\models\User;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {

                /** @var Pages $content */
                if ($content = Pages::findOne(['camel_case' => 'ResetPassword', 'type_id' => Pages::TYPE_MAIL])){
                    $params = [];
                    $replace = [];
                    foreach($user->toArray() as $k => $v){
                        $params[] = "[[user.$k]]";
                        $replace[] = $v;
                    }
                    $resetLink = \Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
                    $params[] = 'resetLink';
                    $replace[] = Html::a(Html::encode($resetLink), $resetLink);

                    $html = str_replace($params, $replace, $content->description);
                    return \Yii::$app->mailer
                        ->compose()
	                    ->setFrom([Setting::findOne(['key' => 'no_reply_email'])->value => Setting::findOne(['key' => 'site_name'])->value . ' no-reply'])
	                    ->setTo($this->email)
                        ->setSubject('Password reset for ' . $user->username)
                        ->setHtmlBody($html)
                        ->send();
                }
            }
        }

        return false;
    }
}
