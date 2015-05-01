<?php

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

    <?php
    Pjax::begin();
    echo GridView::widget([
        'panelBefore' =>
            '<div class="small text-right">
                <div class="pull-right">
                    <span class="btn btn-sm btn-default"></span> Start Transaction&nbsp;
                </div>
                <div class="pull-right">
                    <span class="btn btn-sm btn-warning"></span> User Has Pay&nbsp;
                </div>
                <div class="pull-right">
                    <span class="btn btn-sm btn-info"></span> Confirm&nbsp;
                </div>
                <div class="pull-right">
                    <span class="btn btn-sm btn-primary"></span> Deliver&nbsp;
                </div>
                <div class="pull-right">
                    <span class="btn btn-sm btn-success"></span> Delivered&nbsp;
                </div>
                <div class="pull-right">
                    <span class="btn btn-sm btn-danger"></span> Rejected&nbsp;
                </div>
                <div class="clearfix"></div>
            </div>',
        'dataProvider' => $dataProvider,
        'panelHeading' => '<i class="fa fa-area-chart"></i> Transaction <small>on last 30 days</small>',
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => function($model){
            switch ($model->status){
                case (int) Transaction::STATUS_USER_PAY;
                    $class = 'warning';
                    break;
                case (int) Transaction::STATUS_CONFIRM;
                    $class = 'info';
                    break;
                case (int) Transaction::STATUS_DELIVER;
                    $class = 'bg-primary';
                    break;
                case (int) Transaction::STATUS_DELIVERED;
                    $class = 'success';
                    break;
                case (int) Transaction::STATUS_REJECTED;
                    $class = 'danger';
                    break;
                default;
                    $class = '';
                    break;
            }
            return  [ 'class' => $class ];
        },
        'columns' => [
            [
                'attribute' => 'id',
                'options' => [
                    'style' => 'width:80px'
                ]
            ],
            [
                'attribute' => 'shipping_city_area',
                'value' => 'shipping.cityArea.name'
            ],
            [
                'attribute' => 'status',
                'filter' => Transaction::getStatusAsArray(),
                'value' => function ($data) {
                    $types = Transaction::getStatusAsArray();
                    return $types[$data->status];
                }
            ],
            'grand_total:currency',
            [
                'class' => 'backend\widget\ActionColumn',
                'template' => '<div class="text-center">{view}</div>'
            ]
        ],
    ]);
    Pjax::end();
    ?>

</div>
