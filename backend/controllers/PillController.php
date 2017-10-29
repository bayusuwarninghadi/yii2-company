<?php

namespace backend\controllers;

use common\models\Pages;
use common\models\PagesLang;
use common\models\PagesSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PillController implements the CRUD actions for Pages model.
 */
class PillController extends Controller
{
    /**
     * @return array
     */
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
        $searchModel->type_id = Pages::TYPE_PILL;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('/pill/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => 'Pill'
        ]);
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'update' page.
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
            $model->type_id = Pages::TYPE_PILL;
            if ($model->save()) {
                /**
                 * Save Pages Lang
                 */
                $modelEnglish->page_id = $model->id;
                if ($modelEnglish->load($bodyData, 'modelEnglish') && $modelEnglish->validate()) {
                    $modelEnglish->save();
                }

                $modelIndonesia->page_id = $model->id;
                if ($modelIndonesia->load($bodyData, 'modelIndonesia') && $modelIndonesia->validate()) {
	                $modelIndonesia->subtitle = $modelEnglish->subtitle;
                    $modelIndonesia->save();
                }

                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Item Updated'));
                return $this->redirect(['/pill/update', 'id' => $model->id]);
            }
        }
        return $this->render('/pill/update', [
            'model' => $model,
            'type' => 'Pill',
            'modelEnglish' => $modelEnglish,
            'modelIndonesia' => $modelIndonesia,
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
        if (($model = Pages::findOne(['id' => $id, 'type_id' => Pages::TYPE_PILL])) !== null) {
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
        if (($model = PagesLang::findOne(['page_id' => $pageId, 'language' => $language])) === null) {
            $model = new PagesLang();
            $model->language = $language;
            $model->page_id = $pageId;
        }
        return $model;
    }
}
