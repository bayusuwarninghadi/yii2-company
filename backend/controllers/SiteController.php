<?php
namespace backend\controllers;

use common\models\LoginForm;
use common\models\Request;
use common\models\User;
use common\models\UserComment;
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
                'label' => \Yii::t('app', 'Total Users'),
                'url' => Url::to('/user/index'),
                'icon' => 'fa-users'
            ],
            'totalComment' => [
                'panelType' => 'panel-green',
                'count' => UserComment::find()->count(),
                'label' => \Yii::t('app', 'Total Comments'),
                'url' => Url::to('/user-comment/index'),
                'icon' => 'fa-comments'
            ],
        ];
        return $this->render('index', [
            'requestChart' => Request::chartOptions(10),
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
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
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
}
