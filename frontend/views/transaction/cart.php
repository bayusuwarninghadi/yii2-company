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

$this->title = Yii::t('yii', 'Shopping Cart');
$this->params['breadcrumbs'][] = $this->title;
echo Html::tag('h1', $this->title);
$columns = [
    [
        'label' => Yii::t('yii', 'Image'),
        'value' => function ($cart) {
            return Html::a(Html::img($cart->product->image_url, ['style' => 'width:100px;']), ['/product/view', 'id' => $cart->product_id]);
        },
        'format' => 'raw',
        'options' => [
            'style' => 'width:80px;'
        ]
    ],
    [
        'label' => Yii::t('yii', 'Product'),
        'value' => function ($cart) {
            $return = Html::tag('p', Html::decode($cart->product->name));
            $return .= Html::beginTag('div', ['class' => 'btn-group']);
            $return .= Html::a('<i class="fa fa-pencil"></i>', ['/product/view', 'id' => $cart->product_id], [
                'data-content' => Yii::t('yii', 'Edit Quantity'),
                'class' => 'btn btn-danger',
                'data-toggle' => 'popover',
            ]);
            $return .= Html::a('<i class="fa fa-trash"></i>', ['/transaction/delete', 'id' => $cart->id], [
                'data-content' => Yii::t('yii', 'Remove this product form cart'),
                'data-toggle' => 'popover',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'class' => 'btn btn-danger'
            ]);
            $return .= Html::endTag('div');
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
        'label' => Yii::t('yii', 'Price'),
        'value' => function ($cart) {
            $return = Html::beginTag('div', ['class' => 'text-right']);
            if ($cart->product->discount) {
                $return .= Html::tag('div', '@ ' . Yii::$app->formatter->asCurrency($cart->product->price), ['style' => 'text-decoration:line-through']);
                $return .= Html::tag('span', Yii::$app->formatter->asPercent($cart->product->discount / 100), ['class' => 'label label-success']);
                $return .= Html::tag('h5', Yii::$app->formatter->asCurrency(round($cart->product->price * (100 - ($cart->product->discount)) / 100 * $cart->qty, 0, PHP_ROUND_HALF_UP)));
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

echo GridView::widget([
    'layout' => "
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
    ",
    'panelFooter' => $dataProvider->getModels()
        ? Html::a('<i class="fa fa-shopping-cart"></i> ' . Yii::t('yii', 'Checkout'), ['checkout'], ['class' => 'btn btn-success'])
        : Html::a('<i class="fa fa-search"></i> Go ' . Yii::t('yii', 'Go Shopping'), ['/product/index'], ['class' => 'btn btn-primary']),
    'panelAfter' => "
        <div class='text-right'>
            <h4><small>" . Yii::t('yii', 'Grand Total') . " </small><br/>" . Yii::$app->formatter->asCurrency($grandTotal) . "</h4>
        </div>
    ",
    'dataProvider' => $dataProvider,
    'columns' => $columns
]);

