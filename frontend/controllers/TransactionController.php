<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Cart;
use common\models\ShippingMethod;
use common\models\ShippingMethodCost;
use common\models\Transaction;
use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
         * @var integer $subTotal
         * @var $cartDataProvider ActiveDataProvider
         */
        $cartDataProvider = $cartModel['dataProvider'];
        if (!$cartDataProvider->getModels()) {
            throw new BadRequestHttpException("You don't have any product in your cart.");
        }
        $subTotal = $cartModel['subTotal'];
        $model->sub_total = $subTotal;

        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            $model->grand_total = $subTotal;
            if ($voucher = $model->getVoucher()){
                $model->grand_total -= $voucher->value;
            }

            /**
             * Calculate Shipping
             * @var $shippingCostModel ShippingMethodCost
             */
            if ($shippingCostModel = ShippingMethodCost::findOne(['city_area_id' => $model->shipping->city_area_id])){
                $model->shipping_cost = $shippingCostModel->value;
                $model->grand_total += $shippingCostModel->value;
            }

            return $this->render('summary', [
                'model' => $model,
                'cartDataProvider' => $cartDataProvider,
                'subTotal' => $subTotal,
            ]);

        }

        $notes = Article::find()->where(['title' => 'checkout', 'type_id' => Article::TYPE_PAGES])->one();

        $paymentMethod = [];
        if ($this->settings['bank_transfer']) {
            $paymentMethod['Bank Transfer'] = 'Bank Transfer';
        }

        $shippingMethod = ArrayHelper::map(ShippingMethod::find()->all(),'id','name');

        return $this->render('checkout', [
            'paymentMethod' => $paymentMethod,
            'shippingMethod' => $shippingMethod,
            'model' => $model,
            'cartDataProvider' => $cartDataProvider,
            'subTotal' => $subTotal,
            'notes' => $notes
        ]);
    }

    /**
     * Action Success after checkout
     * @return string|Response
     */
    public function actionSuccess(){
        $model = new Transaction();
        $model->user_id = Yii::$app->user->getId();
        $model->disclaimer = 1;
        $cartModel = $this->findCart();
        /**
         * @var $cartDataProvider ActiveDataProvider
         */
        $cartDataProvider = $cartModel['dataProvider'];

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()){
                /**
                 * Save Transaction Attributes
                 * @var $product Cart
                 */
                foreach ($cartDataProvider->getModels() as $product) {
                    $product->transaction_id = $model->id;
                    $product->save();
                }
                Yii::$app->session->setFlash('success', 'Check your email for next instruction');

                Yii::$app->mailer
                    ->compose('checkout', [
                        'user' => Yii::$app->user->identity,
                        'transaction' => $model,
                        'cartDataProvider' => $cartDataProvider,
                    ])
                    ->setFrom([$this->settings['no_reply_email'] => $this->settings['site_name'] . ' no-reply'])
                    ->setTo(Yii::$app->user->identity->email)
                    ->setSubject('Checkout Success #' . $model->id)
                    ->send();

                return $this->render('success', [
                    'model' => $model,
                    'note' => Article::findOne(['title' => 'success', 'type_id' => Article::TYPE_PAGES]),
                    'cartDataProvider' => $cartDataProvider,
                ]);
            }
        }
        Yii::$app->session->setFlash('error', 'Error during submit your data');
        return $this->redirect('checkout');
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
        $subTotal = 0;
        $model = $dataProvider->getModels();
        /** @var Cart $cart */
        foreach ($model as $cart) {
            $_price = round($cart->product->price * (100 - ($cart->product->discount)) / 100 * $cart->qty, 0, PHP_ROUND_HALF_UP);
            $subTotal += $_price;
        }
        $params = [
            'dataProvider' => $dataProvider,
            'subTotal' => $subTotal
        ];

        return $params;
    }
}
