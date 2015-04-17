<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <?=Html::a('<i class="fa fa-plus fa-fw"></i> Product', ['create'], ['class' => 'btn btn-default pull-right'])?>
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-md-8">
            <?php 
            Pjax::begin();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'value' => function($data){
                            return Html::tag('b',$data->name).Html::tag('div',$data->category->name,['class' => 'text-muted small']);
                        },
                        'format' => 'html'
                    ],
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
                    ['class' => 'backend\widget\ActionColumn'],
                ],
            ]); 
            Pjax::end()
            ?>
        </div>
    </div>
</div>
