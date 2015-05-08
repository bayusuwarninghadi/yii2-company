<?php

namespace backend\controllers;

use common\models\CategorySearch;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use common\models\Category;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->get('node')){
                // nested set
                $node = $this->findModel(Yii::$app->request->get('node-id'));
                switch (Yii::$app->request->get('node')){
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
                    default:
                        break;
                }
            } else {
                $model->makeRoot();
            }

            Yii::$app->session->setFlash('success', Yii::t('app', 'Item Created'));
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item Updated'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
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

}
