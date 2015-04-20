<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\widget\GridView;
use common\models\Transaction;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => [
                    'style' => 'width:80px'
                ]
            ],
            [
                'label' => 'Username',
                'attribute' => 'user_name',
                'value' => 'user.username'
            ],
            [
                'label' => 'Shipping',
                'attribute' => 'shipping_city',
                'value' => 'shipping.city'
            ],
            [
                'attribute' => 'status',
                'filter' => Transaction::getStatusAsArray(),
                'options' => [
                    'style' => 'width:100px;'
                ],
                'value' => function($data){
                    $types = Transaction::getStatusAsArray();
                    return $types[$data->status];
                }
            ],
            'sub_total:currency',
            'grand_total:currency',
            [
                'class' => 'backend\widget\ActionColumn',
                'template' => '<div class="text-center"><div class="btn-group" role="group">{view} {update}</div></div>'
            ],
        ],
    ]);
    Pjax::end();
    ?>

</div>
