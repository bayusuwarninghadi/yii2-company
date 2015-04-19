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
 * @var $cartDataProvider \yii\data\ActiveDataProvider
 * @var $model \common\models\Transaction
 * @var $notes \common\models\Article
 * @var $this \yii\web\View
 * @var $form ActiveForm
 * @var $grandTotal integer
 */

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin();
echo Collapse::widget([
    'items' => [
        [
            'label' => 'Review Your Cart',
            'content' => $this->render('form/_cart', [
                'dataProvider' => $cartDataProvider,
                'grandTotal' => $grandTotal
            ]),
            'contentOptions' => [
                'id' => 'cart-form',
                'class' => 'in'
            ]
        ],
        [
            'label' => 'Shipping Address',
            'content' =>
                $form->field($model, 'shipping_id')->radioList(
                    ArrayHelper::map(Shipping::findAll(['user_id' => Yii::$app->user->getId()]), 'id', 'address'), [
                        'class' => 'radio-form'
                    ]
                ) .
                Html::a('Create New Shipping Address', ['/user/create-shipping'], ['class' => 'btn btn-success'])
            ,
            'contentOptions' => [
                'id' => 'shipping-form',
                'class' => 'in'
            ]
        ],
        [
            'label' => 'Payment Method',
            'content' => HtmlPurifier::process(Yii::$app->controller->settings['bank_transfer']),
            'contentOptions' => [
                'id' => 'cart-form',
                'class' => 'in'
            ]
        ],
        [
            'label' => 'Submit',
            'content' =>
                HtmlPurifier::process($notes->description) .
                $form->field($model, 'note')->textarea(['rows' => 3]) .
                Html::submitButton('Process Checkout', ['class' => 'btn btn-primary']),
            'contentOptions' => [
                'id' => 'cart-form',
                'class' => 'in'
            ]
        ],

    ]
]);
$form->end();