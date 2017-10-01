<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

	<?=Html::a('<i class="fa fa-plus fa-fw"></i> '.$type, ['create'], ['class' => 'btn btn-default pull-right'])?>
    <h1><?= Html::encode($this->title) ?></h1>
	<?php
	Pjax::begin();
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			'title',
			[
				'attribute' => 'order',
				'options' => [
					'style' => 'width:70px;'
				]
			],
			[
                'label' => 'Icon',
                'value' => function($model){
	                return Html::tag('i', '', ['class' => 'fa fa-lg text-primary ' . $model->subtitle]);
                },
                'format' => 'html'
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
                'template' => '{update}'
            ],
		],
	]);
	Pjax::end();
	?>

</div>
