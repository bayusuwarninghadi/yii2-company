<?php
use backend\widget\GridView;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 01:00
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var integer $grandTotal
 */

$this->title = 'Shopping Cart';
$this->params['breadcrumbs'][] = $this->title;

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
        'visible' => !Yii::$app->request->isAjax,
        'value' => function ($cart) {
            $return = Html::tag('p', Html::decode($cart->product->name));
            $return .= Html::a('<i class="fa fa-pencil"></i>', ['/product/view', 'id' => $cart->product_id], [
                'title' => Yii::t('yii', 'Edit Quantity'),
                'class' => 'btn btn-default',
            ]);
            $return .= Html::a('<i class="fa fa-trash"></i>', ['/checkout/delete', 'id' => $cart->id], [
                'title' => Yii::t('yii', 'Remove this product form cart'),
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'class' => 'btn btn-danger'
            ]);
            return $return;
        },
        'format' => 'raw',
        'options' => [
            'style' => 'min-width:300px;'
        ]
    ],
    [
        'attribute' => 'product.name',
        'visible' => Yii::$app->request->isAjax,
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

if (Yii::$app->request->isAjax) {
    $layout = "{items}";
} else {
    $layout = "
        <div class='panel panel-primary'>
            <div class='panel-heading'>
                {panelHeading}
            </div>
            <div class='table-container'>
                {items}
            </div>
            {panelAfter}
            {panelFooter}
        </div>
    ";
}
echo GridView::widget([
    'layout' => $layout,
    'panelFooter' => $dataProvider->getModels()
        ? Html::a('<i class="fa fa-shopping-cart"></i> Checkout', ['index'], ['class' => 'btn btn-success'])
        : Html::a('<i class="fa fa-search"></i> Go Shopping', ['/product/index'], ['class' => 'btn btn-primary']),
    'panelAfter' => "
        <div class='text-right'>
            <h4><small>Grand Total </small><br/>" . Yii::$app->formatter->asCurrency($grandTotal) . "</h4>
        </div>
    ",
    'dataProvider' => $dataProvider,
    'columns' => $columns
]);

