<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;
use common\modules\UploadHelper;
use backend\widget\GridView;
use yii\data\ActiveDataProvider;

/* @var string $this */
/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var string $type */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

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
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'images',
                    'value' => $model->pageImage ? UploadHelper::getHtml('page/' . $model->id . '/' . $model->pageImage->id, 'small') : "",
                    'format' => 'html'
                ],
                'title',
                'subtitle',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
        <div class="panel-body">
            <?= HtmlPurifier::process($model->description) ?>
        </div>
    </div>

	<?php
	echo GridView::widget([
		'panelHeading' => '<span class="glyphicon glyphicon-list"></span> Products',
		'dataProvider' => new ActiveDataProvider([
			'query' => $model->getProducts()
		]),
		'columns' => [
			'title',
			[
				'label' => 'Image',
				'value' => function ($model) {
					/** @var $model \common\models\Pages */
					if (!$model->pageImages) return '';
					return UploadHelper::getHtml('page/' . $model->id . '/' . $model->pageImages[0]->id, 'small');
				},
				'format' => 'html'
			],

			[
				'attribute' => 'order',
				'options' => [
					'style' => 'width:70px;'
				]
			],
			[
				'attribute' => 'created_at',
				'options' => [
					'style' => 'width:110px;'
				],
				'format' => 'date'
			],
			[
				'class' => 'backend\widget\ActionColumn',
                'controller' => 'product',
				'template' => '<div class="text-center"><div class="btn-group" role="group">{view} {update} {delete}</div></div>'
			],
		],
	]);
	?>
</div>
