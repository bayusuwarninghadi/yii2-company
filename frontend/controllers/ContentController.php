<?php

namespace frontend\controllers;

use common\models\Category;
use Yii;
use common\models\Pages;
use common\models\PagesSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContentController implements the CRUD actions for Pages model.
 */
class ContentController extends BaseController
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
        $searchModel->type_id = Pages::TYPE_CONTENT;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => Yii::t('app', 'Content')
        ]);
    }

    /**
     * Displays a single Pages model.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView()
    {
        $type = 'content';
        if (Yii::$app->request->get('id')) {
            $model = Pages::findOne(Yii::$app->request->get('id'));
        } elseif (Yii::$app->request->get('cat_id')) {
            $model = Category::findOne(Yii::$app->request->get('cat_id'));
            $type = 'category';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if (!$model) throw new NotFoundHttpException('The requested page does not exist.');
        return $this->render('view', [
            'model' => $model,
            'type' => $type,
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
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
