<?php
namespace frontend\controllers;

use common\models\Pages;
use common\models\Inbox;
use common\models\LoginForm;
use common\models\User;
use common\modules\UploadHelper;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\HtmlPurifier;
use yii\web\BadRequestHttpException;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $slider = [];
        /**
         * @var $_article Pages
         */
        foreach ($sliderModel = Pages::find()->where(['type_id' => Pages::TYPE_SLIDER])->orderBy('order ASC')->all() as $_article) {
            $slider[] = [
                'content' => UploadHelper::getHtml('slider/' . $_article->id, 'large', [], true),
                'caption' => HtmlPurifier::process($_article->description),
            ];
        }

        $model = new ContactForm();
        if (!\Yii::$app->user->isGuest) {
            $model->name = \Yii::$app->user->identity['username'];
            $model->email = \Yii::$app->user->identity['email'];
        }


        return $this->render('index', [
            'model' => $model,
            'slider' => $slider,
            'contents' => Pages::find()->where(['type_id' => Pages::TYPE_CONTENT])->limit(3)->orderBy('created_at desc')->all(),
            'newsFeeds' => Pages::find()->where(['type_id' => Pages::TYPE_NEWS])->limit(4)->orderBy('created_at desc')->all(),
            'partners' => Pages::find()->where(['type_id' => Pages::TYPE_PARTNER])->limit(8)->orderBy('created_at desc')->all(),
            'page' => Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'Index']),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            $user = $model->getUser();
            \Yii::$app->session->setFlash('success', 'Welcome ' . $user->username);
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if (!\Yii::$app->user->isGuest) {
            $model->name = \Yii::$app->user->identity['username'];
            $model->email = \Yii::$app->user->identity['email'];
        }
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $inbox = new Inbox();
            $inbox->name = $model->name;
            $inbox->email = $model->email;
            $inbox->subject = $model->subject;
            $inbox->message = $model->body;
            $inbox->save();
            if ($model->sendEmail(\Yii::$app->params['adminEmail'])) {
                \Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                \Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('/layouts/page', [
            'model' => Pages::findOne(['camel_case' => 'About', 'type_id' => Pages::TYPE_PAGES])
        ]);
    }

    /**
     * @return string
     */
    public function actionFaq()
    {
        return $this->render('/layouts/page', [
            'model' => Pages::findOne(['camel_case' => 'Faq', 'type_id' => Pages::TYPE_PAGES])
        ]);
    }

    /**
     * @return string
     */
    public function actionTerms()
    {
        return $this->render('/layouts/page', [
            'model' => Pages::findOne(['camel_case' => 'Terms', 'type_id' => Pages::TYPE_PAGES])
        ]);
    }

    /**
     * @return string
     */
    public function actionPrivacy()
    {
        return $this->render('/layouts/page', [
            'model' => Pages::findOne(['camel_case' => 'Privacy', 'type_id' => Pages::TYPE_PAGES])
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        $model = new User();
        if ($model->load(\Yii::$app->request->post())) {
            $model->status = User::STATUS_ACTIVE;
            $model->role = User::ROLE_USER;
            $model->setPassword($model->password);
            $model->generateAuthKey();
            if ($model->save()) {

                /** @var Pages $content */
                if ($content = Pages::findOne(['camel_case' => 'Register', 'type_id' => Pages::TYPE_MAIL])){
                    $params = [];
                    $replace = [];
                    foreach($model->toArray() as $k => $v){
                        $params[] = "[[user.$k]]";
                        $replace[] = $v;
                    }

                    $html = str_replace($params, $replace, $content->description);
                    \Yii::$app->mailer
                        ->compose()
                        ->setFrom([$this->settings['no_reply_email'] => $this->settings['site_name'] . ' no-reply'])
                        ->setTo($model->email)
                        ->setHtmlBody($html)
                        ->setSubject(\Yii::t('app', 'Register Success'))
                        ->send();
                }

                if (\Yii::$app->getUser()->login($model)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                \Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            \Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
