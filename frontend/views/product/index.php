<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-3 col-xs-4">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-md-9 col-xs-8">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list',
                'layout' => '<p>{summary}</p><div class="row">{items}</div>{pager}',
                'itemOptions' => [
                    'class' => 'col-sm-4 col-lg-4 col-md-4'
                ]
            ]); ?>
    </div>
</div>
