<?php

namespace backend\controllers;

use common\models\PagesLang;
use common\modules\UploadHelper;
use common\models\Pages;
use common\models\PagesSearch;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Pages model.
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

	    /**
	     * Create New Pages Language
	     */
	    $modelEnglish = $this->findLangModel($model->id, 'en-US');
	    $modelIndonesia = $this->findLangModel($model->id, 'id-ID');

	    /**
	     * Set Type
	     */
	    $model->type_id = Pages::TYPE_SLIDER;

	    $bodyData = \Yii::$app->request->post();
	    if ($model->load($bodyData)) {
		    $model->camel_case = Inflector::camelize($bodyData['modelEnglish']['title']);
		    if ($model->save()) {
			    if ($image = UploadedFile::getInstance($model, 'image')) {
				    $sizes = [
					    'large' => [
						    'width' => 1000,
						    'format' => 'png'
					    ],
					    'small' => [
						    'width' => 50,
						    'format' => 'png'
					    ],
				    ];

				    UploadHelper::saveImage($image, 'slider/' . $model->id, $sizes);
			    }

			    /**
			     * Save Pages Lang
			     */
			    $modelEnglish->page_id = $model->id;
			    if ($modelEnglish->load($bodyData, 'modelEnglish') && $modelEnglish->validate()) {
				    $modelEnglish->save();
			    }

			    $modelIndonesia->page_id = $model->id;
			    if ($modelIndonesia->load($bodyData, 'modelIndonesia') && $modelIndonesia->validate()) {
				    $modelIndonesia->save();
			    }

			    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Item Created'));
			    return $this->redirect(['index']);
		    }
	    }
	    return $this->render('create', [
		    'model' => $model,
		    'type' => 'Slider',
		    'modelEnglish' => $modelEnglish,
		    'modelIndonesia' => $modelIndonesia,
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

	    $modelEnglish = $this->findLangModel($model->id, 'en-US');
	    $modelIndonesia = $this->findLangModel($model->id, 'id-ID');

	    $bodyData = \Yii::$app->request->post();

	    if ($model->load($bodyData)) {
	    	$model->camel_case = Inflector::camelize($bodyData['modelEnglish']['title']);
		    $model->type_id = Pages::TYPE_SLIDER;
		    if ($model->save()) {
			    if ($image = UploadedFile::getInstance($model, 'image')) {
				    $sizes = [
					    'large' => [
						    'width' => 1000,
						    'format' => 'png'
					    ],
					    'small' => [
						    'width' => 50,
						    'format' => 'png'
					    ],
				    ];

				    UploadHelper::saveImage($image, 'slider/' . $model->id, $sizes);
			    }

			    /**
			     * Save Pages Lang
			     */
			    $modelEnglish->page_id = $model->id;
			    if ($modelEnglish->load($bodyData, 'modelEnglish') && $modelEnglish->validate()) {
			    	$modelEnglish->subtitle = $model->subtitle;
				    $modelEnglish->save();
			    }

			    $modelIndonesia->page_id = $model->id;
			    if ($modelIndonesia->load($bodyData, 'modelIndonesia') && $modelIndonesia->validate()) {
				    $modelIndonesia->subtitle = $model->subtitle;
				    $modelIndonesia->save();
			    }

			    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Item Updated'));
			    return $this->redirect(['index']);
		    }
	    }
        return $this->render('update', [
            'model' => $model,
            'type' => 'Slider',
	        'modelEnglish' => $modelEnglish,
	        'modelIndonesia' => $modelIndonesia,
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
	/**
	 * Finds the PagesLang model based on its primary key value.
	 * @param integer $pageId
	 * @param string $language
	 * @return PagesLang the loaded model
	 */
	protected function findLangModel($pageId, $language)
	{
		if (($model = PagesLang::findOne([
				'page_id' => $pageId,
				'language' => $language])) === null) {
			$model = new PagesLang();
			$model->language = $language;
			$model->page_id = $pageId;
		}
		return $model;
	}
}
