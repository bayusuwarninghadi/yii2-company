<?php
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 01:00
 *
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var integer $grandTotal
 */

$columns = [
    [
        'label' => 'Image',
        'value' => function ($cart) {
            return Html::a(Html::img($cart->product->image_url, ['style' => 'height:80px;']), ['/product/view', 'id' => $cart->product_id]);
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
            return $return;
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'qty',
        'visible' => !Yii::$app->request->isAjax,
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
];

$layout = "{items}
        <div class='text-right'>
            <h4><small>Grand Total </small><br/>" . Yii::$app->formatter->asCurrency($grandTotal) . "</h4>
        </div>";

echo GridView::widget([
    'layout' => $layout,
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'filterModel' => null
]);

