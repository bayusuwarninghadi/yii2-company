<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;
use common\models\User;


/* @var $this yii\web\View */
/* @var $searchModel \backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?=Html::a('<i class="fa fa-plus fa-fw"></i> User', ['create'], ['class' => 'btn btn-default pull-right'])?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => User::getStatusAsArray(),
                'options' => [
                    'style' => 'width:100px;'
                ],
                'value' => function($data){
                    $types = User::getStatusAsArray();
                    return $types[$data->status];
                }
            ],
            [
                'attribute' => 'role',
                'filter' => User::getRoleAsArray(),
                'options' => [
                    'style' => 'width:100px;'
                ],
                'value' => function($data){
                    $types = User::getRoleAsArray();
                    return $types[$data->role];
                }
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
