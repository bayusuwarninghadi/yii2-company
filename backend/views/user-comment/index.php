<?php

use backend\widget\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app', 'User Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(\Yii::t('app', 'Create User Comment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'table_key',
            'user.username',
            'title',
            'rating',
            'created_at:datetime',

            ['class' => 'backend\widget\ActionColumn'],
        ],
    ]); ?>

</div>
