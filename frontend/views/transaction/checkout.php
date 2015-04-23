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
 * @var $model \common\models\Transaction
 * @var $notes \common\models\Article
 * @var $this \yii\web\View
 * @var $form ActiveForm
 * @var $cartDataProvider \yii\data\ActiveDataProvider
 * @var $grandTotal integer
 */

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin(['id' => 'checkout-form']);
echo Collapse::widget([
    'encodeLabels' => false,
    'items' => [
        [
            'label' => '<i class="fa fa-expand fa-fw"></i> Review Your Cart',
            'content' => $this->render('cartAjax', [
                'dataProvider' => $cartDataProvider,
                'grandTotal' => $grandTotal
            ]),
            'contentOptions' => [
                'id' => 'cart-form',
                'class' => 'in'
            ],
            'options' => [
                'class' => 'panel-success'
            ]
        ],
        [
            'label' => '<i class="fa fa-expand fa-fw"></i> Shipping Address',
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
            ],
            'options' => [
                'class' => 'panel-info'
            ],
        ],
        [
            'label' => '<i class="fa fa-expand fa-fw"></i> Payment Method',
            'content' =>
                $form->field($model, 'shipping_id')->radioList(
                    [
                        HtmlPurifier::process(Yii::$app->controller->settings['bank_transfer']) => HtmlPurifier::process(Yii::$app->controller->settings['bank_transfer'])
                    ]
                ),
            'contentOptions' => [
                'id' => 'cart-form',
                'class' => 'in'
            ],
            'options' => [
                'class' => 'panel-warning'
            ]
        ],
        [
            'label' => '<i class="fa fa-expand fa-fw"></i> Submit',
            'content' =>
                HtmlPurifier::process($notes->description) .
                $form->field($model, 'note')->textarea(['rows' => 3]) .
                $form->field($model, 'disclaimer')->checkbox(['label' => 'I agree to the our '.Html::a('Terms And Condition', '/site/terms')]) .
                Html::submitButton('Process Checkout', ['class' => 'btn btn-primary']),
            'contentOptions' => [
                'id' => 'cart-form',
                'class' => 'in'
            ],
            'options' => [
                'class' => 'panel-danger'
            ]
        ],

    ]
]);
$form->end();