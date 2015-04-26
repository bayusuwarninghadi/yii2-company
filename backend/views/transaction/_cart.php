<?php
use backend\widget\GridView;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/21/15
 * Time: 22:28
 *
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'Image',
            'value' => function ($model) {
                return Html::a(Html::img(Yii::$app->components['frontendSiteUrl'] . $model->product->image_url, ['style' => 'width:100px;']), ['/product/view', 'id' => $model->product_id]);
            },
            'format' => 'raw',
            'options' => [
                'style' => 'width:80px;'
            ]
        ],
        [
            'label' => 'Product',
            'value' => function ($model) {
                $return = Html::tag('p', Html::decode($model->product->name));
                $return .= Html::tag('p', Html::decode($model->product->subtitle));
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
            'value' => function ($model) {
                $return = Html::beginTag('div', ['class' => 'text-right']);
                if ($model->product->discount) {
                    $return .= Html::tag('div', '@ ' . Yii::$app->formatter->asCurrency($model->product->price), ['style' => 'text-decoration:line-through']);
                    $return .= Html::tag('span', Yii::$app->formatter->asPercent($model->product->discount / 100), ['class' => 'label label-success']);
                    $return .= Html::tag('h5', Yii::$app->formatter->asCurrency($model->product->price * (100 - ($model->product->discount)) / 100 * $model->qty));
                } else {
                    $return .= Html::tag('h5', Yii::$app->formatter->asCurrency($model->product->price));
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
