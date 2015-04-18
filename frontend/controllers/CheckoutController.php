<?php

namespace frontend\controllers;

use common\models\Cart;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
     *
     */
    public function actionIndex()
    {

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

        $query = Cart::find()->where(['user_id' => Yii::$app->user->getId()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
        ]);

        $grandTotal = 0;

        $model = $query->all();
        /** @var Cart $cart */
        foreach ($model as $cart){
            $_price = $cart->product->price * (100 - ($cart->product->discount)) / 100 * $cart->qty;
            $grandTotal += $_price;
        }

        return $this->render('cart', [
            'dataProvider' => $dataProvider,
            'grandTotal' => $grandTotal
        ]);

    }


}
