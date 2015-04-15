<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category[] */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-list fa-fw"></i> Category Tree</div>
        <div class="category-index-tree">
            <?=$this->render('_list',[ 'model' => $model ])?>
        </div>
    </div>
</div>
