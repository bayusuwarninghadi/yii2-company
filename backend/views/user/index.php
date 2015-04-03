<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;
use common\models\User;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panelBefore' => Html::a('Create New', ['create'], ['class' => 'btn btn-success']),
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => User::getStatusAsArray(),
                'value' => function($data){
                    $types = User::getStatusAsArray();
                    return $types[$data->status];
                }
            ],
            [
                'attribute' => 'role',
                'filter' => User::getRoleAsArray(),
                'value' => function($data){
                    $types = User::getRoleAsArray();
                    return $types[$data->role];
                }
            ],
            'created_at:date',

            ['class' => 'backend\widget\ActionColumn'],
        ],
    ]); 
    Pjax::end();
    ?>

</div>
