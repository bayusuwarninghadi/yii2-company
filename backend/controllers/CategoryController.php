<?php

namespace backend\controllers;

use common\models\CategoryLang;
use common\models\CategorySearch;
use common\modules\UploadHelper;
use creocoder\nestedsets\NestedSetsBehavior;
use common\models\Category;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => new CategorySearch()
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var $model Category|NestedSetsBehavior */
        $model = new Category();

        $bodyData = \Yii::$app->request->post();
        
        if ($model->load($bodyData)) {
            if (\Yii::$app->request->get('node')){
                // nested set
                $node = $this->findModel(\Yii::$app->request->get('node-id'));
                switch (\Yii::$app->request->get('node')){
                    case 'prepend':
                        $model->prependTo($node);
                        break;
                    case 'append':
                        $model->appendTo($node);
                        break;
                    case 'before':
                        $model->insertBefore($node, false);
                        break;
                    case 'after':
                        $model->insertAfter($node, false);
                        break;
                }
            } else {
                /**
                 * assuming first row is root
                 * @var Category|NestedSetsBehavior $root
                 */
                $root = Category::find()->one();
                $model->prependTo($root);
            }

            if ($image = UploadedFile::getInstance($model, 'image')){
                UploadHelper::saveImage($image, 'category/' . $model->id);
            }
            /**
             * Save Pages Lang
             */
            $modelEnglish = $this->findLangModel($model->id, 'en-US');
            $modelIndonesia = $this->findLangModel($model->id, 'id-ID');

            $modelEnglish->cat_id = $model->id;
            if ($modelEnglish->load($bodyData, 'modelEnglish') && $modelEnglish->validate()) {
                $modelEnglish->save();
            }

            $modelIndonesia->cat_id = $model->id;
            if ($modelIndonesia->load($bodyData, 'modelIndonesia') && $modelIndonesia->validate()) {
                $modelIndonesia->save();
            }

            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Item Created'));
            return $this->redirect(['index']);
        }

        $modelEnglish = $this->findLangModel($model->id, 'en-US');
        $modelIndonesia = $this->findLangModel($model->id, 'id-ID');

        return $this->render('create', [
            'model' => $model,
            'modelEnglish' => $modelEnglish,
            'modelIndonesia' => $modelIndonesia,
        ]);
    }

    /**
     * Updates an existing Category model.
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
        if ($model->load($bodyData) && $model->save()) {

            if ($image = UploadedFile::getInstance($model, 'image')){
                UploadHelper::saveImage($image, 'category/' . $model->id);
            }

            /**
             * Save Pages Lang
             */
            if ($modelEnglish->load($bodyData, 'modelEnglish') && $modelEnglish->validate()) {
                $modelEnglish->save();
            }

            if ($modelIndonesia->load($bodyData, 'modelIndonesia') && $modelIndonesia->validate()) {
                $modelIndonesia->save();
            }

            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Item Updated'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelEnglish' => $modelEnglish,
                'modelIndonesia' => $modelIndonesia,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the CategoryLang model based on its primary key value.
     * @param integer $cat_id
     * @param string $language
     * @return CategoryLang the loaded model
     */
    protected function findLangModel($cat_id, $language)
    {
        if (($model = CategoryLang::findOne(['cat_id' => $cat_id, 'language' => $language])) === null) {
            $model = new CategoryLang();
            $model->language = $language;
            $model->cat_id = $cat_id;
        }
        return $model;
    }
}
