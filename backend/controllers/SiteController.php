<?php
namespace backend\controllers;

use common\models\LoginForm;
use common\models\Product;
use common\models\Request;
use common\models\Transaction;
use common\models\User;
use common\models\UserComment;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        $transactionDataProvider = new ActiveDataProvider([
            'query' => Transaction::find()
                ->where(['IN', 'status', [Transaction::STATUS_USER_UN_PAY, Transaction::STATUS_USER_PAY]])
                ->orderBy('created_at DESC'),
            'sort' => false,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        $userDataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['role' => User::ROLE_USER])->limit(5)->orderBy('created_at DESC'),
            'sort' => false,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        $siteStats = [
            'totalUser' => [
                'panelType' => 'panel-yellow',
                'count' => User::find()->count(),
                'label' => Yii::t('app','Total Users'),
                'url' => Url::to('/user/index')
            ],
            'totalComment' => [
                'panelType' => 'panel-green',
                'count' => UserComment::find()->count(),
                'label' => Yii::t('app','Total Comments'),
                'url' => Url::to('/user-comment/index')
            ],
            'totalTransaction' => [
                'panelType' => 'panel-red',
                'count' => Transaction::find()->count(),
                'label' => Yii::t('app','Total Transaction'),
                'url' => Url::to('/transaction/index')
            ],
            'totalProduct' => [
                'panelType' => 'panel-primary',
                'count' => Product::find()->count(),
                'label' => Yii::t('app','Total Product'),
                'url' => Url::to('/product/index')
            ],
        ];
        return $this->render('index', [
            'requestChart' => Request::chartOptions(10),
            'transactionChart' => Transaction::chartOptions(10),
            'transactionDataProvider' => $transactionDataProvider,
            'userDataProvider' => $userDataProvider,
            'siteStats' => $siteStats,
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
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
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
