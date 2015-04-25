<?php
use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 01:00
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var integer $grandTotal
 */

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'emptyTextOptions' => ['class' => 'list-group-item'],
    'itemView' => '_list',
    'layout' => '{items}' . Html::tag('div', 'Grand Total ' . Yii::$app->formatter->asCurrency($grandTotal), ['class' => 'list-group-item list-group-item-danger text-right strong']),
    'itemOptions' => [
        'class' => 'list-group-item'
    ],
    'options' => [
        'class' => 'cart-list list-group'
    ],
]);


