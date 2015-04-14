<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    Pjax::begin();  
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panelBefore' => Html::a('Create New', ['create'], ['class' => 'btn btn-success']),
        'columns' => [
            'title',
            [
                'attribute' => 'order',
                'options' => [
                    'style' => 'width:70px;'
                ]
            ],
            [
                'attribute' => 'created_at',
                'options' => [
                    'style' => 'width:110px;'
                ],
                'format' => 'date'
            ],
            ['class' => 'backend\widget\ActionColumn'],
        ],
    ]); 
    Pjax::end();
    ?>

</div>
