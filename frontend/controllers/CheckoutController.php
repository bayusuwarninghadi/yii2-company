<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Cart;
use common\models\Transaction;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

/**
 * Class TransactionController
 * @package frontend\controllers
 */
class CheckoutController extends BaseController
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
     * Checkout
     */
    public function actionIndex()
    {
        $model = new Transaction();
        $model->user_id = Yii::$app->user->getId();

        $cartModel = $this->findCart();

        /**
         * @var integer $grandTotal
         * @var $cartDataProvider ActiveDataProvider
         */
        $cartDataProvider = $cartModel['dataProvider'];
        $grandTotal = $cartModel['grandTotal'];

        if (!$cartDataProvider->getModels()){
            throw new BadRequestHttpException("You don't have any product in your cart, ".Html::a('Start Shopping' ,['/product']));
        }
        $notes = Article::find()->where(['title' => 'checkout_note', 'type_id' => Article::TYPE_PAGES])->one();
        return $this->render('index',[
            'model' => $model,
            'cartDataProvider' => $cartDataProvider,
            'grandTotal' => $grandTotal,
            'notes' => $notes
        ]);

    }

    /**
     *
     */
    public function actionHistory()
    {

    }


    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        if ($model = Cart::find()->where(['user_id' => Yii::$app->user->getId(), 'id' => $id])->one()){
            $model->delete();
            return $this->redirect(['cart']);
        } else{
            throw new ForbiddenHttpException('Permission Denied');
        }
    }

    /**
     * ViewCurrentChart.
     * @return mixed
     */
    public function actionCart()
    {
        $params = $this->findCart();
        return Yii::$app->request->isAjax ? $this->renderPartial('cartAjax',$params) : $this->render('cart', $params);

    }

    /**
     * @return array
     */
    protected function findCart(){
        $query = Cart::find()->where(['user_id' => Yii::$app->user->getId()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
        ]);
        $grandTotal = 0;
        $model = $dataProvider->getModels();
        /** @var Cart $cart */
        foreach ($model as $cart){
            $_price = $cart->product->price * (100 - ($cart->product->discount)) / 100 * $cart->qty;
            $grandTotal += $_price;
        }
        $params = [
            'dataProvider' => $dataProvider,
            'grandTotal' => $grandTotal
        ];

        return $params;

    }
}
