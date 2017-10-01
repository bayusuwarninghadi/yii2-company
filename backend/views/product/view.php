<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;
use yii\bootstrap\Carousel;


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
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							'title',
							'subtitle',
							[
                                'label' => 'Description',
                                'format' => 'html',
                                'value' => HtmlPurifier::process($model->description)
                            ],
							[
								'label' => 'Tags',
								'value' => function ($model) {
									/** @var $model \common\models\Pages */
									$tags = '';
									if ($model->pageTags) {
										foreach (explode(',', $model->pageTags->value) as $tag) {
											$tags .= Html::tag('span', $tag, ['class' => 'label label-primary']) . ' ';
										}
									}
									return $tags;
								},
								'format' => 'html'
							],
							'created_at:datetime',
							'updated_at:datetime',
						],
					]) ?>
                </div>
            </div>
        </div>


    </div>

</div>
