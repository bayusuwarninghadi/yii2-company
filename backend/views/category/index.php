<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category[] */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-list fa-fw"></i> Category Tree</div>
        <div class="panel-body list-group-item">
            <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="category-index-tree">
            <?php if ($model) :?>
                <?=$this->render('_list',[ 'model' => $model, 'level' => 1 ])?>
            <?php else : ?>
                <div class="panel-body">Category not found, <?= Html::a('Create', ['create']) ?></div>
            <?php endif ?>
        </div>
    </div>
</div>
