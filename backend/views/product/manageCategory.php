<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category[] */

$this->title = 'Category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <?=Html::a('<i class="fa fa-plus fa-fw"></i> Category', ['create-category'], ['class' => 'btn btn-default pull-right'])?>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-list fa-fw"></i> Available Category
        </div>
        <?=$this->render('_categoryList',['model' => $model, 'level' => 1])?>
    </div>
</div>
