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
    <div class="row">
        <div class="col-md-3 col-sm-4">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-md-9 col-sm-8">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list',
                'layout' => '<p>{summary}</p><div class="row">{items}</div>{pager}',
                'itemOptions' => [
                    'class' => 'col-sm-6 col-lg-4 col-md-4 col-xs-6'
                ]
            ]); ?>
        </div>
    </div>
</div>
