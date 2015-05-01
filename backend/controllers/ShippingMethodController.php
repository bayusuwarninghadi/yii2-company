<?php

namespace backend\controllers;

use backend\models\UploadShippingMethod;
use common\models\City;
use common\models\CityArea;
use common\models\ShippingMethodCost;
use common\models\ShippingMethodCostSearch;
use Yii;
use yii\base\NotSupportedException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShippingMethodController implements the CRUD actions for ShippingMethodCost model.
 */
class ShippingMethodController extends Controller
{
    /**
     * @return array
     */
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
     * Download sample excel file
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDownloadSample()
    {
        $file = Yii::$app->getBasePath() . '/../common/modules/jne/sample.xls';
        if (!file_exists($file)) {
            throw new NotFoundHttpException("Sample file doesn't exist");
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        return $this->goBack();
    }

    /**
     * Upload existing excel
     * @return string|\yii\web\Response
     */
    public function actionUpload()
    {
        $model = New UploadShippingMethod();
        if ($model->load(Yii::$app->request->post())) {
            /*
             * Increase ini set
             */
            ini_set('max_execution_time', 3000);
            if ($model->import()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Upload Success'));
                return $this->redirect('index');
            }
        }
        return $this->render('upload', [
            'model' => $model
        ]);
    }

    /**
     * Lists all ShippingMethodCost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShippingMethodCostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShippingMethodCost model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ShippingMethodCost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShippingMethodCost();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item Created'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShippingMethodCost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Updated'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
        }
        $model->province_id = $model->cityArea->city->province_id;
        $model->city_id = $model->cityArea->city_id;
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ShippingMethodCost model.
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
     * Finds the ShippingMethodCost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShippingMethodCost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShippingMethodCost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * actionDynamicDropdown
     *
     * @param $model
     * @param $id
     * @return string
     * @throws NotSupportedException
     */
    public function actionDynamicDropdown($model, $id)
    {
        switch ($model) {
            case 'city':
                return Html::dropDownList('city', null, ArrayHelper::map(City::findAll(['province_id' => $id]), 'id', 'name'));
                break;
            case 'city_area':
                return Html::dropDownList('city', null, ArrayHelper::map(CityArea::findAll(['city_id' => $id]), 'id', 'name'));
                break;
        }
        throw new NotSupportedException("Doesn't support for Model $model");
    }

}
