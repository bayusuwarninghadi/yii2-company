<?php

use backend\widget\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Product');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <?= Html::a('<i class="fa fa-plus fa-fw"></i> Product', ['create'], ['class' => 'btn btn-default pull-right']) ?>
    <h1>
        <?= Html::a('<i class="fa fa-bars fa-fw"></i>', '', ['class' => 'toggle-search']) ?>
        <?= Html::encode($this->title) ?>
    </h1>
    <div class="product-wrapper">

        <div class="product-sidebar">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="product-content-wrapper transition">
            <?php
            Pjax::begin();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'value' => function ($data) {
                            return Html::tag('b', $data->name) . Html::tag('div', $data->category->name, ['class' => 'text-muted small']);
                        },
                        'format' => 'html'
                    ],
                    'price:currency',
                    [
                        'attribute' => 'discount',
                        'value' => function ($data) {
                            return $data->discount / 100;
                        },
                        'options' => [
                            'style' => 'width:50px'
                        ],
                        'format' => 'percent'
                    ],
                    [
                        'attribute' => 'productTotalView.int_value',
                        'value' => function ($data) {
                            return $data->productTotalView ? $data->productTotalView->int_value : 0;
                        }
                    ],
                    [
                        'attribute' => 'stock',
                        'options' => [
                            'style' => 'width:50px'
                        ]
                    ],
                    ['class' => 'backend\widget\ActionColumn'],
                ],
            ]);
            Pjax::end();?>
        </div>
    </div>
</div>
