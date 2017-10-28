<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;
use common\modules\UploadHelper;
use common\models\Pages;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

	<?= Html::a('<i class="fa fa-plus fa-fw"></i> ' . $type, ['create'], ['class' => 'btn btn-default pull-right']) ?>
    <h1><?= Html::encode($this->title) ?></h1>
	<?php
	Pjax::begin();
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
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
				'label' => 'Brand',
				'attribute' => 'brand_id',
				'value' => 'brand.title',
                'filter' => ArrayHelper::map(Pages::findAll(['type_id' => Pages::TYPE_BRAND]), 'id', 'title')
			],
			[
				'label' => 'Discount',
				'attribute' => 'discount',
				'value' => function ($model) {
					/** @var $model \common\models\Pages */
					return (intval($model->pageDiscount->int_value) > 0) ? $model->pageDiscount->int_value . '%' : null;
				},
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
			['class' => 'backend\widget\ActionColumn'],
		],
	]);
	Pjax::end();
	?>

</div>
