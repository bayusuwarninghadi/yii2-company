<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\Pages;
use common\models\ShippingMethod;
use common\models\ShippingMethodCost;
use common\models\Transaction;
use common\models\TransactionSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/**
 * Class TransactionController
 * @package frontend\controllers
 */
class TransactionController extends BaseController
{


    /**
     * History Transaction
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $searchModel->user_id = Yii::$app->user->getId();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

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
            if ($voucher = $model->getVoucher()) {
                $model->grand_total -= $voucher->value;
            }

            /**
             * Calculate Shipping
             * @var $shippingCostModel ShippingMethodCost
             */
            if ($shippingCostModel = ShippingMethodCost::findOne(['city_area_id' => $model->shipping->city_area_id])) {
                $model->shipping_cost = $shippingCostModel->value;
                $model->grand_total += $shippingCostModel->value;
            }

            return $this->render('summary', [
                'model' => $model,
                'cartDataProvider' => $cartDataProvider,
            ]);

        }

        $note = Pages::find()->where(['camel_case' => 'Checkout', 'type_id' => Pages::TYPE_PAGES])->one();

        $paymentMethod = [];
        if ($this->settings['bank_transfer']) {
            $paymentMethod['Bank Transfer'] = 'Bank Transfer';
        }

        $shippingMethod = ArrayHelper::map(ShippingMethod::find()->all(), 'id', 'name');

        return $this->render('checkout', [
            'paymentMethod' => $paymentMethod,
            'shippingMethod' => $shippingMethod,
            'model' => $model,
            'cartDataProvider' => $cartDataProvider,
            'subTotal' => $subTotal,
            'note' => $note
        ]);
    }

    /**
     * Action Success after checkout
     * @return string|Response
     */
    public function actionSuccess()
    {
        $model = new Transaction();
        $model->user_id = Yii::$app->user->getId();
        $model->disclaimer = 1;
        $cartModel = $this->findCart();
        /**
         * @var $cartDataProvider ActiveDataProvider
         */
        $cartDataProvider = $cartModel['dataProvider'];

        if ($model->load(Yii::$app->request->post())) {

            if (true) {
                /**
                 * Save Transaction Attributes
                 * @var $product Cart
                 */
                foreach ($cartDataProvider->getModels() as $product) {
                    $product->transaction_id = $model->id;
                    $product->save();
                }
                Yii::$app->session->setFlash('success', 'Check your email for next instruction');

                /** @var Pages $content */
                if ( false && $content = Pages::findOne(['camel_case' => 'Checkout', 'type_id' => Pages::TYPE_MAIL])) {
                    $params = [];
                    $replace = [];
                    foreach ($model->toArray() as $k => $v) {
                        $params[] = "[[transaction.$k]]";
                        $replace[] = $v;
                    }

                    $params[] = '[[transaction.product]]';
                    $replace[] = $this->renderPartial(
                        '/transaction/cartAjax', [
                            'dataProvider' => $cartDataProvider,
                            'subTotal' => $model->sub_total
                        ]
                    );

                    $params[] = '[[transaction.detail]]';
                    $replace[] = DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'payment_method',
                            'shipping.address',
                            'shipping.cityArea.name',
                            'shipping.cityArea.city.name',
                            'shipping.postal_code',
                            'shippingMethod.name',
                            'shipping_cost:currency',
                            [
                                'label' => Yii::t('app', 'Voucher'),
                                'value' => ($model->voucher)
                                    ?
                                    Html::tag('h2', $model->voucher_code . ' <small class="line-through">' . Yii::$app->formatter->asCurrency($model->voucher->value) . '</small>')
                                    : '',
                                'format' => 'html'
                            ],
                            'note',
                        ],
                    ]);

                    $html = str_replace($params, $replace, $content->description);
                    Yii::$app->mailer
                        ->compose()
                        ->setFrom([$this->settings['no_reply_email'] => $this->settings['site_name'] . ' no-reply'])
                        ->setTo(Yii::$app->user->identity->email)
                        ->setHtmlBody($html)
                        ->setSubject('Checkout Success #' . $model->id)
                        ->send();
                }

                $note = Pages::findOne(['camel_case' => 'Success', 'type_id' => Pages::TYPE_PAGES]);
                return $this->render('success', [
                    'model' => $model,
                    'note' => $note,
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
        $model = $this->findModel($id);
        $cartModel = $this->findCart();
        /**
         * @var $cartDataProvider ActiveDataProvider
         */
        $cartDataProvider = $cartModel['dataProvider'];

        return $this->render('view', [
            'model' => $model,
            'cartDataProvider' => $cartDataProvider
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
     * ViewCurrentCart.
     * @param integer $id transaction_id
     * @return mixed
     */
    public function actionCart($id = null)
    {
        $params = $this->findCart($id);
        return Yii::$app->request->isAjax ? $this->renderPartial('cartAjax', $params) : $this->render('cart', $params);

    }

    /**
     * find product attribute of transaction
     * if $id == null
     * return current basket
     *
     * @param integer $id transaction_id
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
