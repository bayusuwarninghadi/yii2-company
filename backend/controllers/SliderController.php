<?php

namespace backend\controllers;

use common\modules\UploadHelper;
use common\models\Pages;
use common\models\PagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Pages model.
 */
class SliderController extends Controller
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
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagesSearch();
        $searchModel->type_id = Pages::TYPE_SLIDER;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => 'Slider'
        ]);
    }

    /**
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pages();
        $model->type_id = Pages::TYPE_SLIDER;
        $model->title = 'Slider';
        $model->camel_case = 'Slider';
        if ($model->load(\Yii::$app->request->post())) {
            if ($model->save()) {
                $image = UploadedFile::getInstance($model, 'image');
                UploadHelper::saveImage($image, 'slider/' . $model->id,[
                    'large' => [
                        'width' => 1000,
                        'format' => 'jpeg'
                    ],
                    'small' => [
                        'width' => 50,
                        'format' => 'jpeg'
                    ],
                ]);
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Item Created'));
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'type' => 'Slider'
        ]);
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->title = 'Slider';
        $model->camel_case = 'Slider';
        if ($model->load(\Yii::$app->request->post())) {
            $model->type_id = Pages::TYPE_SLIDER;
            if ($model->save()) {
                $image = UploadedFile::getInstance($model, 'image');
                UploadHelper::saveImage($image, 'slider/' . $model->id,[
                    'large' => [
                        'width' => 1000,
                        'format' => 'jpeg'
                    ],
                    'small' => [
                        'width' => 50,
                        'format' => 'jpeg'
                    ],
                ]);
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Item Updated'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'type' => 'Slider'
        ]);
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = Pages::findOne(['id' => $id, 'type_id' => Pages::TYPE_SLIDER])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
