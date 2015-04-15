<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $parent common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-green">
        <div class="panel-heading"><i class="fa fa-list fa-fw"></i> Detail</div>
        <?php
        $parent = $model->parents(1)->one();
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                [
                    'label' => 'parent',
                    'value' => ($parent) ? $parent->name : ''
                ]
            ],
        ]) ?>
        <div class="panel-body">
            <?=Html::decode($model->description)?>
        </div>
    </div>

</div>
