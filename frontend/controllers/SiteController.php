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
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\web\BadRequestHttpException;
use Yii;

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

	public function actionIndex()
	{
		$slider = [];
		/**
		 * @var $sliderModel Pages
		 */
		$sliderModels = Pages::find()->where(['type_id' => Pages::TYPE_SLIDER])->orderBy('order ASC')->all();
		foreach ($sliderModels as $sliderModel) {
			$image = UploadHelper::getHtml($sliderModel->getImagePath(), 'large', ['class' => 'img-responsive'], true);
			$content = Html::tag('h1', $sliderModel->title) .
				Html::tag('p', HtmlPurifier::process($sliderModel->description));

			if ($sliderModel->subtitle) {
				$content = Html::a($content, $sliderModel->subtitle);
			}

			$slider[] = Html::tag('div',
				Html::tag('div', $content, ['class' => 'col-sm-5 right']) .
				Html::tag('div', $image, ['class' => 'col-sm-7']),
				['class' => 'row']
			);
		}


		$contactForm = new ContactForm();
		if (!\Yii::$app->user->isGuest) {
			$contactForm->name = \Yii::$app->user->identity['username'];
			$contactForm->email = \Yii::$app->user->identity['email'];
		}

		$pills = Pages::find()->where(['type_id' => Pages::TYPE_PILL])->limit(3)->orderBy('created_at desc')->all();
		$indexPage = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'Index']);
		$indexPartner = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'PartnerHeader']);
		$indexNews = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'NewsHeader']);
		$indexProduct = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'ProductHeader']);
		$newsFeed = Pages::find()->where(['type_id' => Pages::TYPE_NEWS])->limit(8)->orderBy('created_at desc')->all();

		/** @var $products Pages[] */
		$products = Pages::find()->where(['type_id' => Pages::TYPE_PRODUCT, 'order' => '0'])->orderBy('created_at desc')->all();
		$productItems = [];

		foreach ($products as $product) {
		    $content = Html::beginTag('div', ['class' => 'box-image-text blog']);

		    $content .= Html::beginTag('div', ['class' => 'top']);
		    $content .= Html::tag('div', UploadHelper::getHtml($product->getImagePath(), 'medium', ['class' => 'img-responsive']), ['class' => 'image']);
			$content .= Html::tag('div', '', ['class' => 'bg']);
		    $content .= Html::beginTag('div', ['class' => 'text']);
			$content .= Html::tag('p', Html::a('<i class="fa fa-link"></i> ' . Yii::t('app', 'Read More'), ['/product/view', 'id' => $product->id], ['class' => 'btn btn-template-transparent-primary']), ['class' => 'button']);
			$content .= Html::endTag('div');
			$content .= Html::endTag('div');


		    $content .= Html::beginTag('div', ['class' => 'content']);
			$content .= Html::tag('h4', Html::a($product->title, ['/product/view', 'id' => $product->id]), ['class' => 'bg']);
			$content .= Html::tag('p', $product->subtitle, ['class' => 'author-category']);
			$content .= Html::tag('p', HtmlPurifier::process($product->subtitle), ['class' => 'intro']);
			$content .= Html::tag('p', Html::a('Continue Reading', ['/product/view', 'id' => $product->id], ['class' => 'btn btn-template-main']), ['class' => 'read-more']);
			$content .= Html::endTag('div');

			$content .= Html::endTag('div');
			$productItems[] = $content;
        }

	    /** @var $partners Pages[] */
	    $partners = Pages::find()->where(['type_id' => Pages::TYPE_PARTNER])->limit(8)->orderBy('created_at desc')->all();
	    $partnerItems = [];
	    foreach ($partners as $partner) {
		    $content = Html::beginTag('div', ['class' => 'testimonial same-height-always']);
		    $content .= Html::tag('div', $partner->description, ['class' => 'text']);

		    $content .= Html::beginTag('div', ['class' => 'bottom']);
		    $content .= Html::tag('div', '<i class="fa fa-quote-left"></i>', ['class' => 'icon']);
		    $content .= Html::tag('div',
			    UploadHelper::getHtml($partner->getImagePath(), 'small', ['class' => 'img-responsive']) .
			    Html::tag('h5', $partner->title) .
			    Html::tag('p', $partner->subtitle),
			    ['class' => 'name-picture']
		    );

		    $content .= Html::endTag('div');

		    $content .= Html::endTag('div');
		    $partnerItems[] = $content;
	    }

	    $contactPopup = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'AddressMap']);

	    return $this->render('homepage', [
		    'contactForm' => $contactForm,
		    'slider' => $slider,
		    'newsFeeds' => $newsFeed,
		    'productItems' => $productItems,
		    'partnerItems' => $partnerItems,
		    'pills' => $pills,
		    'indexPage' => $indexPage,
		    'indexPartner' => $indexPartner,
		    'indexProduct' => $indexProduct,
		    'indexNews' => $indexNews,
		    'contactPopup' => $contactPopup,
	    ]);
    }

	/**
	 * @return string
	 */
	public function actionIndexOld()
	{
		$slider = [];
		/**
		 * @var $sliderModel Pages
		 */
		$sliderModels = Pages::find()->where(['type_id' => Pages::TYPE_SLIDER])->orderBy('order ASC')->all();
		foreach ($sliderModels as $sliderModel) {
			$content = UploadHelper::getHtml($sliderModel->getImagePath(), 'large', [], true);
			if ($sliderModel->subtitle) {
				$content = Html::a($content, $sliderModel->subtitle);
			}
			$slider[] = [
				'content' => $content,
				'caption' => Html::tag('h2', $sliderModel->title) . Html::tag('p', HtmlPurifier::process($sliderModel->description), ['class' => 'hidden-xs']),
			];
		}

		$contactForm = new ContactForm();
		if (!\Yii::$app->user->isGuest) {
			$contactForm->name = \Yii::$app->user->identity['username'];
			$contactForm->email = \Yii::$app->user->identity['email'];
		}

		$pills = Pages::find()->where(['type_id' => Pages::TYPE_PILL])->limit(3)->orderBy('created_at desc')->all();
		$indexPage = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'Index']);

		$indexPartner = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'PartnerHeader']);
		$indexNews = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'NewsHeader']);
		$indexProduct = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'ProductHeader']);
		$contactPopup = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'AddressMap']);


		$newsFeed = Pages::find()->where(['type_id' => Pages::TYPE_NEWS])->limit(4)->orderBy('created_at desc')->all();

		$products = Pages::find()->where(['type_id' => Pages::TYPE_PRODUCT])->limit(3)->orderBy('created_at desc')->all();

		$partners = Pages::find()->where(['type_id' => Pages::TYPE_PARTNER])->limit(4)->orderBy('created_at desc')->all();

		return $this->render('index', [
			'contactForm' => $contactForm,
			'slider' => $slider,
			'newsFeeds' => $newsFeed,
			'products' => $products,
			'partners' => $partners,
			'pills' => $pills,
			'indexPage' => $indexPage,
			'indexPartner' => $indexPartner,
			'indexNews' => $indexNews,
			'indexProduct' => $indexProduct,
			'contactPopup' => $contactPopup,
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
			$inbox->subject = 'Contact site feedback';
			$inbox->message = $model->body;
			$inbox->save();
			if ($model->sendEmail(\Yii::$app->params['adminEmail'])) {
				\Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
			} else {
				\Yii::$app->session->setFlash('error', 'There was an error sending email.');
			}

			return $this->refresh();
		} else {
			$contactPopup = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'AddressMap']);
			return $this->render('contact', [
				'model' => $model,
				'contactPopup' => $contactPopup,
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
