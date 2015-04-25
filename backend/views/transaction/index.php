<?php

use backend\widget\chart\Morris;
use backend\widget\GridView;
use common\models\Transaction;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $transactionChart array */
/* @var $searchModel common\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-primary">
        <div class="panel-heading">
            Transaction
            <small>on last 30 days</small>
        </div>
        <div class="panel-body">
            <?= Morris::widget($transactionChart) ?>
        </div>
    </div>
    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => function($data){
            return ($data->confirmations) ? [ 'class' => 'danger' ] : [];
        },
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
                'value' => function ($data) {
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
