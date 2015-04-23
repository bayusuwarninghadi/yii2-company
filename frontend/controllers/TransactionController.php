<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Cart;
use common\models\Transaction;
use common\models\TransactionSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class TransactionController
 * @package frontend\controllers
 */
class TransactionController extends BaseController
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
    public function actionCheckout()
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
        $model->sub_total = $grandTotal;
        $model->grand_total = $grandTotal;

        if (!$cartDataProvider->getModels()) {
            throw new BadRequestHttpException("You don't have any product in your cart.");
        }

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            /**
             * Save Transaction Attributes
             * @var $product Cart
             */
            foreach($products = $cartDataProvider->getModels() as $product){
                $product->transaction_id = $model->id;
                $product->save();
            }
            Yii::$app->session->setFlash('success', 'Check your email for next instruction');
            return $this->redirect(['success', 'id' => $model->id]);
        }

        $notes = Article::find()->where(['title' => 'checkout', 'type_id' => Article::TYPE_PAGES])->one();

        $paymentMethod = [
            $this->settings['bank_transfer'] => $this->settings['bank_transfer']
        ];

        return $this->render('checkout', [
            'paymentMethod' => $paymentMethod,
            'model' => $model,
            'cartDataProvider' => $cartDataProvider,
            'grandTotal' => $grandTotal,
            'notes' => $notes
        ]);

    }

    /**
     * Action Success after checkout
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSuccess($id)
    {
        $model = $this->findModel($id);
        $note = Article::findOne(['title' => 'success', 'type_id' => Article::TYPE_PAGES]);

        $cartModel = $this->findCart();
        /**
         * @var integer $grandTotal
         * @var $cartDataProvider ActiveDataProvider
         */
        $cartDataProvider = $cartModel['dataProvider'];
        $grandTotal = $cartModel['grandTotal'];

        return $this->render('success', [
            'model' => $model,
            'note' => $note,
            'cartDataProvider' => $cartDataProvider,
            'grandTotal' => $grandTotal,
        ]);

    }

    /**
     * History Transaction
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $searchModel->user_id = Yii::$app->user->getId();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * History Transaction Detail
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        if ($model = Cart::find()->where(['user_id' => Yii::$app->user->getId(), 'id' => $id])->one()) {
            $model->delete();
            return $this->redirect(['cart']);
        } else {
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
        return Yii::$app->request->isAjax ? $this->renderPartial('cartAjax', $params) : $this->render('cart', $params);

    }

    /**
     * find product attribute of transaction
     * if $id == null
     * return current basket
     *
     * @param integer $id
     * @return array
     */
    protected function findCart($id = null)
    {
        $query = Cart::find()->where(['user_id' => Yii::$app->user->getId()]);

        if ($id) {
            $query->andWhere(['transaction_id' => $id]);
        } else {
            $query->andWhere('transaction_id IS NULL');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
        ]);
        $grandTotal = 0;
        $model = $dataProvider->getModels();
        /** @var Cart $cart */
        foreach ($model as $cart) {
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
