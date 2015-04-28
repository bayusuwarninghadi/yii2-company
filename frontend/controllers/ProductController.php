<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\ProductAttribute;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\helpers\Html;
use yii\helpers\Json;
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
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $cartModel = Cart::find()->where(
            'user_id = :user_id AND product_id = :product_id AND transaction_id IS NULL',
            [
                'user_id' => Yii::$app->user->getId(),
                'product_id' => $model->id
            ])->one();
        if ($cartModel === null){
            $cartModel = new Cart();
        }

        $cartModel->user_id = Yii::$app->user->getId();

        if ($cartModel->load(Yii::$app->request->post()) && $cartModel->save()) {
            Yii::$app->session->setFlash('success', 'Success, the product has been added to your cart');
            return $this->redirect(['/transaction/cart']);
        }

        $gallery = ProductAttribute::findAll(['product_id' => $model->id, 'key' => 'images']);

        $images = [];
        foreach ($gallery as $image){
            $_arr = Json::decode($image->value);
            $images[] = Html::img($_arr['medium']);
        }
        if (!$images) $images[] = Html::img($model->image_url);

        return $this->render('view', [
            'model' => $model,
            'cartModel' => $cartModel,
            'images' => $images,
            'attributes' => $model->getProductAttributeDetailValue()
        ]);
    }

    /**
     * Displays a single Product Gallery.
     * @param integer $id
     * @return mixed
     */
    public function actionGallery($id)
    {
        $model = $this->findModel($id);

        $gallery = ProductAttribute::findAll(['product_id' => $model->id, 'key' => 'images']);

        $images = [];
        foreach ($gallery as $image){
            $_arr = Json::decode($image->value);
            $images[] = Html::img($_arr['large']);
        }
        if (!$images) $images[] = Html::img($model->image_url);

        $params = ['images' => $images];
        return Yii::$app->request->isAjax ? $this->renderPartial('_gallery', $params) : $this->render('_gallery', $params);
    }

    /**
     * Displays Related Product.
     * @param integer $id
     * @return mixed
     */
    public function actionRelated($id)
    {
        $model = $this->findModel($id);

        $models = Product::find()->where(
            "MATCH (name,subtitle,description) AGAINST (:string IN BOOLEAN MODE)",[
                ':string' => Html::encode($model->name.' '.$model->subtitle)
            ]
        )->andFilterWhere(['<>','id',$model->id])->orderBy('created_at DESC')->limit(4)->all();
        $params = [
            'model' => $model,
            'models' => $models
        ];
        return Yii::$app->request->isAjax ? $this->renderPartial('related', $params) : $this->render('related', $params);

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
