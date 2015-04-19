<?php

use common\models\Product;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $images array */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['index']];
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
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-green">
                <div class="panel-heading"><i class="fa fa-picture-o fa-fw"></i> Gallery</div>
                <?=Carousel::widget([
                    'items' => $images,
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left"></span>',
                        '<span class="glyphicon glyphicon-chevron-right"></span>',
                    ]
                ])?>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="panel panel-green">
                <div class="panel-heading"><i class="fa fa-list fa-fw"></i> Detail</div>
                <?php
                $status = Product::getStatusAsArray();
                $visible = Product::getVisibleAsArray();

                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'subtitle',
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
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <?=HtmlPurifier::process($model->description)?>
</div>
