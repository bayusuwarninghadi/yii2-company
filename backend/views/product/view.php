<?php

use common\models\Product;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;
use yii\helpers\Inflector;
use common\modules\UploadHelper;
use yii\bootstrap\Tabs;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $images array */
/* @var $attributes array */
/* @var $userCommentDataProvider \yii\data\ActiveDataProvider */

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
        <div class="col-sm-6 col-md-7">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-picture-o fa-fw"></i> Gallery</div>
                <?=Carousel::widget([
                    'items' => $images,
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left"></span>',
                        '<span class="glyphicon glyphicon-chevron-right"></span>',
                    ]
                ])?>
                <div class="panel-body">
                    <?php
                    $arr = explode('/', $model->rating);
                    echo Tabs::widget([
                        'items' => [
                            [
                                'label' => 'Description',
                                'content' => HtmlPurifier::process($model->description),
                            ],
                            [
                                'label' => $arr[1] . ' Reviews',
                                'content' => ListView::widget([
                                    'dataProvider' => $userCommentDataProvider,
                                    'itemView' => '/user-comment/_list',
                                    'separator' => '<hr/>',
                                ]),
                            ],
                        ],

                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-5">
            <div class="panel panel-green">
                <div class="panel-heading"><i class="fa fa-list fa-fw"></i> Detail</div>
                <?php
                $status = Product::getStatusAsArray();
                $visible = Product::getVisibleAsArray();

                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'Brand',
                            'value' => UploadHelper::getHtml('brand/'.$model->brand_id),
                            'format' => 'html'
                        ],
                        'name',
                        'subtitle:ntext',
                        'category.name',
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
                <div class="list-group-item">
                    <h3> Custom Detail</h3>
                </div>
                <table class="table table-striped table-bordered ">
                    <?php foreach ($attributes as $name => $detail) :?>
                        <tr>
                            <th><?=Inflector::camel2words($name)?></th>
                            <td><?=Html::decode($detail)?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>
</div>
