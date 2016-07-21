<?php

namespace frontend\controllers;

use common\models\Pages;
use common\models\PagesSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Pages model.
 */
class ArticleController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagesSearch();
        $searchModel->type_id = Pages::TYPE_ARTICLE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('/article/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => 'Pages'
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('/article/view', [
            'model' => $this->findModel($id),
            'type' => 'Pages'
        ]);
    }

    /**
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne(['id' => $id, 'type_id' => Pages::TYPE_ARTICLE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
