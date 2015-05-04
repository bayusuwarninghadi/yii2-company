<?php
use common\models\Shipping;
use yii\bootstrap\Collapse;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/19/15
 * Time: 22:59
 *
 * @var $note \common\models\Pages
 * @var $this \yii\web\View
 * @var $model \common\models\Transaction
 * @var $form ActiveForm
 * @var $cartDataProvider \yii\data\ActiveDataProvider
 * @var $subTotal integer
 * @var $paymentMethod array
 * @var $shippingMethod array
 */

$this->title = Yii::t('app', 'Checkout');
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin(['id' => 'checkout-form', 'enableAjaxValidation' => true]);
echo Collapse::widget([
    'encodeLabels' => false,
    'items' => [
        [
            'label' => '<i class="fa fa-shopping-cart fa-fw"></i> ' . Yii::t('app', 'Review Your Cart'),
            'content' => $this->render('cartAjax', [
                'dataProvider' => $cartDataProvider,
                'subTotal' => $subTotal
            ]),
            'contentOptions' => [
                'id' => 'cart-form',
                'class' => 'in'
            ],
            'options' => [
                'class' => 'panel-danger'
            ]
        ],
        [
            'label' => '<i class="fa fa-map-marker fa-fw"></i> ' . Yii::t('app', 'Shipping Address'),
            'content' =>
                $form->field($model, 'shipping_id')->radioList(
                    ArrayHelper::map(Shipping::findAll(['user_id' => Yii::$app->user->getId()]), 'id', 'address'), [
                        'class' => 'radio-form radio'
                    ]
                ) .
                Html::a('Create New Shipping Address', ['/user/create-shipping'], ['class' => 'btn btn-success'])
            ,
            'contentOptions' => [
                'id' => 'shipping-form',
                'class' => 'in'
            ],
            'options' => [
                'class' => 'panel-info'
            ],
        ],
        [
            'label' => '<i class="fa fa-ship fa-fw"></i> ' . Yii::t('app', 'Shipping Method'),
            'content' =>
                $form->field($model, 'shipping_method_id')->radioList($shippingMethod,[
                    'class' => 'radio-form radio'
                ]),
            'contentOptions' => [
                'id' => 'shipping-method-form',
                'class' => 'in'
            ],
            'options' => [
                'class' => 'panel-success'
            ]
        ],
        [
            'label' => '<i class="fa fa-cc-visa fa-fw"></i> ' . Yii::t('app', 'Payment Method'),
            'content' =>
                $form->field($model, 'payment_method')->radioList($paymentMethod,[
                    'class' => 'radio-form radio'
                ]),
            'contentOptions' => [
                'id' => 'payment-method-form',
                'class' => 'in'
            ],
            'options' => [
                'class' => 'panel-warning'
            ]
        ],
        [
            'label' => '<i class="fa fa-paper-plane fa-fw"></i> ' . Yii::t('app', 'Calculate'),
            'content' =>
                $form->field($model, 'voucher_code')->textInput().
                $form->field($model, 'note')->textarea(['rows' => 3]) .
                HtmlPurifier::process($note->description) .
                $form->field($model, 'disclaimer')->checkbox(['label' => Yii::t('app', 'I agree to the our') . ' ' . Html::a(Yii::t('app', 'Terms And Condition'), '/site/terms')]) .
                Html::submitButton(Yii::t('app', 'Calculate'), ['class' => 'btn btn-primary']),
            'contentOptions' => [
                'id' => 'cart-form',
                'class' => 'in'
            ],
            'options' => [
                'class' => 'panel-primary'
            ]
        ],

    ]
]);
$form->end();