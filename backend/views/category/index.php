<?php

use yii\helpers\Html;
use backend\widget\category\CategoryWidget;

/* @var $this yii\web\View */
/* @var $model common\models\CategorySearch */

$this->title = 'Category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <?=Html::a('<i class="fa fa-plus fa-fw"></i> Category', ['create'], ['class' => 'btn btn-default pull-right'])?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?=CategoryWidget::widget([
        'model' => $model,
        'attribute' => 'id',
        'renderOption' => true
    ])?>
</div>
