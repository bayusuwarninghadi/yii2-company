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
class ArticleController extends Controller
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

        /**
         * Create New Article Language
         */
        $modelEnglish = new ArticleLang();
        $modelEnglish->language = 'id-ID';

        $modelIndonesia = new ArticleLang();
        $modelIndonesia->language = 'en-US';

        /**
         * Set Type
         */
        $model->type_id = Article::TYPE_ARTICLE;

        $bodyData = Yii::$app->request->post();
        if ($model->load($bodyData)) {
            $model->camel_case = Inflector::camelize($bodyData['modelEnglish']['title']);
            if ($model->save()) {

                /**
                 * Save Article Lang
                 */
                $modelEnglish->article_id = $model->id;
                $modelEnglish->title = $bodyData['modelEnglish']['title'];
                $modelEnglish->description = $bodyData['modelEnglish']['description'];
                if ($modelEnglish->validate()) {
                    $modelEnglish->save();
                }

                $modelIndonesia->article_id = $model->id;
                $modelIndonesia->title = $bodyData['modelIndonesia']['title'];
                $modelIndonesia->description = $bodyData['modelIndonesia']['description'];
                if ($modelIndonesia->validate()) {
                    $modelIndonesia->save();
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Created'));
                return $this->redirect(['/article/view', 'id' => $model->id]);
            }
        }

        return $this->render('/article/create', [
            'model' => $model,
            'type' => 'Article',
            'modelEnglish' => $modelEnglish,
            'modelIndonesia' => $modelIndonesia,
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

        $modelEnglish = $this->findLangModel($model->id, 'en-US');
        $modelIndonesia = $this->findLangModel($model->id, 'id-ID');

        $bodyData = Yii::$app->request->post();

        if ($model->load($bodyData)) {
            $model->camel_case = Inflector::camelize($bodyData['modelEnglish']['title']);
            $model->type_id = Article::TYPE_ARTICLE;
            if ($model->save()) {
                /**
                 * Save Article Lang
                 */
                $modelEnglish->title = $bodyData['modelEnglish']['title'];
                $modelEnglish->description = $bodyData['modelEnglish']['description'];
                if ($modelEnglish->validate()) {
                    $modelEnglish->save();
                }

                $modelIndonesia->title = $bodyData['modelIndonesia']['title'];
                $modelIndonesia->description = $bodyData['modelIndonesia']['description'];
                if ($modelIndonesia->validate()) {
                    $modelIndonesia->save();
                }

                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Updated'));
                return $this->redirect(['/article/view', 'id' => $model->id]);
            }
        }
        return $this->render('/article/update', [
            'model' => $model,
            'type' => 'Article',
            'modelEnglish' => $modelEnglish,
            'modelIndonesia' => $modelIndonesia,
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
