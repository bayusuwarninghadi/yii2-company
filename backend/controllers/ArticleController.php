<?php

namespace backend\controllers;

use Yii;
use common\models\Article;
use common\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $searchModel->type_id = Article::TYPE_ARTICLE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/article/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => 'Article'
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('/article/view', [
            'model' => $this->findModel($id),
            'type' => 'Article'
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $model->type_id = Article::TYPE_ARTICLE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/article/view', 'id' => $model->id]);
        } else {
            return $this->render('/article/create', [
                'model' => $model,
                'type' => 'Article'
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->type_id = Article::TYPE_ARTICLE;
            if ($model->save()) {
                return $this->redirect(['/article/view', 'id' => $model->id]);                
            }
        }
        return $this->render('/article/update', [
            'model' => $model,
            'type' => 'Article'
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/article/index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id, 'type_id' => Article::TYPE_ARTICLE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
