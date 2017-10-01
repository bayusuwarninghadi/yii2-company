<?php

namespace backend\controllers;

use common\models\PageAttribute;
use common\models\Pages;
use common\models\PagesLang;
use common\models\PagesSearch;
use common\modules\UploadHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

/**
 * ContentController implements the CRUD actions for Pages model.
 */
class ContentController extends Controller
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
        $searchModel->type_id = Pages::TYPE_CONTENT;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/content/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => Yii::t('app', 'Content')
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('/content/view', [
            'model' => $this->findModel($id),
            'type' => Yii::t('app', 'Content')
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

        $bodyData = Yii::$app->request->post();

        if ($model->load($bodyData)) {
            $model->type_id = Pages::TYPE_CONTENT;
            $model->camel_case = Inflector::camelize($bodyData['modelEnglish']['title']);
            if ($model->save()){

	            if (isset($bodyData['Pages']['pageTags'])){
		            if (($tags = $model->pageTags) == null){
			            $tags = new PageAttribute();
			            $tags->page_id = $model->id;
			            $tags->key = 'tags';
		            }
		            $tags->value = $bodyData['Pages']['pageTags']['value'];
		            $tags->save();
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
                
                if ($modelIndonesia->validate()) {
                    $modelIndonesia->save();
                }

                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Created'));
                return $this->redirect(['/content/view', 'id' => $model->id]);
            }
        }
        return $this->render('/content/create', [
            'model' => $model,
            'type' => Yii::t('app', 'Content'),
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

        $bodyData = Yii::$app->request->post();

        if ($model->load($bodyData)) {
            $model->type_id = Pages::TYPE_CONTENT;
            $model->camel_case = Inflector::camelize($bodyData['modelEnglish']['title']);
            if ($model->save()) {

	            if (isset($bodyData['Pages']['pageTags'])){
		            if (($tags = $model->pageTags) == null){
			            $tags = new PageAttribute();
			            $tags->page_id = $model->id;
			            $tags->key = 'tags';
		            }
		            $tags->value = $bodyData['Pages']['pageTags']['value'];
		            $tags->save();
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

                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Updated'));
                return $this->redirect(['/content/view', 'id' => $model->id]);
            }
        }
        return $this->render('/content/update', [
            'model' => $model,
            'type' => Yii::t('app', 'Content'),
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

        return $this->redirect(['/content/index']);
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
        if (($model = Pages::findOne(['id' => $id, 'type_id' => Pages::TYPE_CONTENT])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the PagesLang model based on its primary key value.
     * @param integer $productId
     * @param string $language
     * @return PagesLang the loaded model
     */
    protected function findLangModel($productId, $language)
    {
        if (($model = PagesLang::findOne(['page_id' => $productId, 'language' => $language])) === null) {
            $model = new PagesLang();
            $model->language = $language;
            $model->page_id = $productId;
        }
        return $model;
    }

}
