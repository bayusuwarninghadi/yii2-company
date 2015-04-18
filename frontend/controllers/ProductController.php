<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\ProductAttribute;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
{
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
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @var Cart $cartModel
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (($cartModel = Cart::findOne(['user_id' => Yii::$app->user->getId(),'product_id' => $model->id])) === null){
            $cartModel = new Cart();
        }

        $cartModel->user_id = Yii::$app->user->getId();

        if ($cartModel->load(Yii::$app->request->post()) && $cartModel->save()) {
            return $this->redirect(['checkout/cart']);
        }

        $gallery = ProductAttribute::findAll(['product_id' => $model->id, 'key' => 'images']);

        return $this->render('view', [
            'model' => $model,
            'cartModel' => $cartModel,
            'gallery' => $gallery
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $searchModel->visible = Product::VISIBLE_VISIBLE;
        $searchModel->status = Product::STATUS_ACTIVE;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
