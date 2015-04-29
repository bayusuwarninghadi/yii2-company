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
    'panelHeading' => '<i class="fa fa-check-circle"></i> Confirmation',
    'panelType' => 'panel-red',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'Attachment',
            'value' => function ($model) {
                return Html::img(Yii::$app->components['backendSiteUrl'] . '/images/transactions/' . $model->transaction_id . '/' . $model->id . '/medium.jpeg', ['style' => 'width:100px;']);
            },
            'format' => 'raw',
            'options' => [
                'style' => 'width:80px;'
            ]
        ],
        'name',
        'amount:currency',
        'payment_method',
        'created_at:date'
    ]
]);
