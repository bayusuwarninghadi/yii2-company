<?php

namespace backend\controllers;

use common\models\Article;
use common\models\ArticleLang;
use common\models\ArticleSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ArticleController implements the CRUD actions for Article model.
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
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $searchModel->type_id = Article::TYPE_PAGES;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => 'Pages'
        ]);
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

        $articleEnglish = $this->findLangModel($model->id, 'en-US');
        $articleIndonesia = $this->findLangModel($model->id, 'id-ID');

        $bodyData = Yii::$app->request->post();
        $model->camel_case = Inflector::camelize($bodyData['articleEnglish']['title']);

        if ($model->load($bodyData)) {
            $model->type_id = Article::TYPE_PAGES;
            if ($model->save()) {
                /**
                 * Save Article Lang
                 */
                $articleEnglish->title = $bodyData['articleEnglish']['title'];
                $articleEnglish->description = $bodyData['articleEnglish']['description'];
                if ($articleEnglish->validate()) {
                    $articleEnglish->save();
                }

                $articleIndonesia->title = $bodyData['articleIndonesia']['title'];
                $articleIndonesia->description = $bodyData['articleIndonesia']['description'];
                if ($articleIndonesia->validate()) {
                    $articleIndonesia->save();
                }

                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Updated'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'type' => 'Pages',
            'articleEnglish' => $articleEnglish,
            'articleIndonesia' => $articleIndonesia,
        ]);
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
        if (($model = Article::findOne(['id' => $id, 'type_id' => Article::TYPE_PAGES])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the ArticleLang model based on its primary key value.
     * @param integer $articleId
     * @param string $language
     * @return ArticleLang the loaded model
     */
    protected function findLangModel($articleId, $language)
    {
        if (($model = ArticleLang::findOne(['article_id' => $articleId, 'language' => $language])) === null) {
            $model = new ArticleLang();
            $model->language = $language;
            $model->article_id = $articleId;
        }
        return $model;
    }

}
