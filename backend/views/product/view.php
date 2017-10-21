<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;
use yii\bootstrap\Carousel;
use yii\helpers\Inflector;
use yii\helpers\Json;


/* @var string $this */
/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $images array */
/* @var string $type */



$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
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
        <div class="panel-body">
            <div class="row">
				<?php if (!empty($images)) : ?>
                    <div class="col-sm-6">

						<?= Carousel::widget([
							'items' => $images,
							'options' => [
								'class' => 'slide'
							],
							'controls' => [
								'<span class="glyphicon glyphicon-chevron-left"></span>',
								'<span class="glyphicon glyphicon-chevron-right"></span>',
							]
						]) ?>
                    </div>
				<?php endif ?>

                <div class="col-sm-6">
					<?php

					$items = [
						'title',
						'subtitle',
						[
							'label' => 'Description',
							'format' => 'html',
							'value' => HtmlPurifier::process($model->description)
						],
						'created_at:datetime',
						'updated_at:datetime',
						[
							'label' => 'Tags',
							'value' => function ($model) {
								/** @var $model \common\models\Pages */
								$tags = '';
								if ($model->pageTags) {
									foreach (Json::decode($model->pageTags->value) as $tag) {
										$tags .= Html::tag('span', $tag, ['class' => 'label label-default']) . ' ';
									}
								}
								return $tags;
							},
							'format' => 'html'
						],
						[
                            'label' => 'Color',
	                        'value' => function ($model) {
		                        /** @var $model \common\models\Pages */
		                        $tags = '';
		                        if ($model->pageColor) {
			                        foreach (Json::decode($model->pageColor->value) as $tag) {
				                        $tags .= Html::tag('span', $tag, ['class' => 'label label-primary']) . ' ';
			                        }
		                        }
		                        return $tags;
	                        },
	                        'format' => 'html'
                        ],
                        [
                            'label' => 'Size',
	                        'value' => function ($model) {
		                        /** @var $model \common\models\Pages */
		                        $tags = '';
		                        if ($model->pageSize) {
			                        foreach (Json::decode($model->pageSize->value) as $tag) {
				                        $tags .= Html::tag('span', $tag, ['class' => 'label label-warning']) . ' ';
			                        }
		                        }
		                        return $tags;
	                        },
	                        'format' => 'html'
                        ]
					];

					foreach ($model->detail as $name => $detail) {
						$items[] = [
							'label' => Inflector::camel2words($name),
							'value' => Html::decode($detail)
						];
					}
					echo DetailView::widget([
						'model' => $model,
						'attributes' => $items,
					]) ?>
                </div>
            </div>
        </div>


    </div>

</div>
