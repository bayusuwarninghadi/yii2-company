<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Inbox */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inboxes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbox-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Pjax::begin();  
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            'email:email',
            'subject:ntext',
            'created_at:datetime',
            [
                'class' => 'backend\widget\ActionColumn',
                'template' => '<div class="text-center"><div class="btn-group" role="group">{view}{delete}</div></div>'
            ],
        ],
    ]); 
    Pjax::end();
    ?>

</div>
