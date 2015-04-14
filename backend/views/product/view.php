<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

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
        $status = Product::getStatusAsArray();
        $visible = Product::getVisibleAsArray();

        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'price:currency',
                [
                    'attribute' => 'discount',
                    'value' => $model->discount / 100,
                    'format' => 'percent'
                ],
                'stock',
                [
                    'label' => 'Status',
                    'value' => $status[$model->status]
                ],
                [
                    'label' => 'Visible',
                    'value' => $visible[$model->visible]
                ],
                'order',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
        <div class="panel-body">
            <?=Html::decode($model->description)?>
        </div>
    </div>

</div>
