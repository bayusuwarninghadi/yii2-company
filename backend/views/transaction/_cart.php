<?php
use yii\data\ActiveDataProvider;
use backend\widget\GridView;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/21/15
 * Time: 22:28
 *
 * @var $carts \common\models\Cart;
 */

echo GridView::widget([
    'panelHeading' => '<span class="glyphicon glyphicon-truck"></span> Product',
    'dataProvider' => new ActiveDataProvider([
        'sort' => false,
        'query' => $carts,
    ]),
    'columns' => [
        [
            'label' => 'Image',
            'value' => function ($cart) {
                return Html::a(Html::img(Yii::$app->components['frontendSiteUrl'].$cart->product->image_url, ['style' => 'width:100px;']), ['/product/view', 'id' => $cart->product_id]);
            },
            'format' => 'raw',
            'options' => [
                'style' => 'width:80px;'
            ]
        ],
        [
            'label' => 'Product',
            'value' => function ($cart) {
                $return = Html::tag('p', Html::decode($cart->product->name));
                $return .= Html::tag('p', Html::decode($cart->product->subtitle));
                return $return;
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'qty',
            'options' => [
                'style' => 'width:10px;'
            ]
        ],
        [
            'label' => 'Price',
            'value' => function ($cart) {
                $return = Html::beginTag('div', ['class' => 'text-right']);
                if ($cart->product->discount) {
                    $return .= Html::tag('div', '@ ' . Yii::$app->formatter->asCurrency($cart->product->price), ['style' => 'text-decoration:line-through']);
                    $return .= Html::tag('span', Yii::$app->formatter->asPercent($cart->product->discount / 100), ['class' => 'label label-success']);
                    $return .= Html::tag('h5', Yii::$app->formatter->asCurrency($cart->product->price * (100 - ($cart->product->discount)) / 100 * $cart->qty));
                } else {
                    $return .= Html::tag('h5', Yii::$app->formatter->asCurrency($cart->product->price));
                }
                $return .= Html::endTag('div');
                return $return;
            },
            'format' => 'raw',
            'options' => [
                'style' => 'width:200px;'
            ]
        ],

    ]
]);
