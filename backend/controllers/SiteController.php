<?php
namespace backend\controllers;

use common\models\LoginForm;
use common\models\Request;
use common\models\Transaction;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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

    public function actionIndex()
    {
        $transactionDataProvider = new ActiveDataProvider([
            'query' => Transaction::find()
                ->where(['IN', 'status', [Transaction::STATUS_USER_UN_PAY, Transaction::STATUS_USER_PAY]])
                ->limit(5)
                ->orderBy('created_at DESC'),
            'sort' => false
        ]);
        $userDataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['role' => User::ROLE_USER])->limit(5)->orderBy('created_at DESC'),
            'sort' => false
        ]);
        return $this->render('index', [
            'requestChart' => Request::chartOptions(10),
            'transactionChart' => Transaction::chartOptions(10),
            'transactionDataProvider' => $transactionDataProvider,
            'userDataProvider' => $userDataProvider
        ]);
    }

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

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
