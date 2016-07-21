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
 * ArticleController implements the CRUD actions for Pages model.
 */
class PagesController extends Controller
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
        $searchModel->type_id = Pages::TYPE_PAGES;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => 'Pages'
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
        
        if ($bodyData) {
            $model->type_id = Pages::TYPE_PAGES;
            $model->camel_case = Inflector::camelize($modelEnglish->title);
            $modelIndonesia->title = $modelEnglish->title;
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
                    $modelIndonesia->save();
                }

                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Item Updated'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'type' => 'Pages',
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
        if (($model = Pages::findOne(['id' => $id, 'type_id' => Pages::TYPE_PAGES])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the PagesLang model based on its primary key value.
     * @param integer $articleId
     * @param string $language
     * @return PagesLang the loaded model
     */
    protected function findLangModel($articleId, $language)
    {
        if (($model = PagesLang::findOne(['page_id' => $articleId, 'language' => $language])) === null) {
            $model = new PagesLang();
            $model->language = $language;
            $model->page_id = $articleId;
        }
        return $model;
    }

}
