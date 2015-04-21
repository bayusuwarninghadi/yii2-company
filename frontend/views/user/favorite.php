<?php
use yii\widgets\ListView;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/22/15
 * Time: 00:06
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var \yii\web\View
 */
$this->title = "Product Favorites";
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '/product/_list',
    'layout' => '<p>{summary}</p><div class="row">{items}</div>{pager}',
    'itemOptions' => [
        'class' => 'col-lg-3 col-md-4 col-sm-4 col-xs-6'
    ]
]);