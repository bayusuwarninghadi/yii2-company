<?php

use yii\helpers\Html;
use common\models\Product;
use backend\widget\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panelBefore' => Html::a('Create New', ['create'], ['class' => 'btn btn-success']),
        'columns' => [
            'name',
            'category_name',
            'price:currency',
            [
                'attribute' => 'discount',
                'value' => function($data){
                    return $data->discount / 100;
                },
                'options' => [
                    'style' => 'width:50px'
                ],
                'format' => 'percent'
            ],
            [
                'attribute' => 'stock',
                'options' => [
                    'style' => 'width:50px'
                ]
            ],
            [
                'attribute' => 'status',
                'filter' => Product::getStatusAsArray(),
                'value' => function($data){
                    $status = Product::getStatusAsArray();
                    return $status[$data->status];
                },
                'options' => [
                    'style' => 'width:80px'
                ]
            ],
            ['class' => 'backend\widget\ActionColumn'],
        ],
    ]); 
    ?>
</div>
