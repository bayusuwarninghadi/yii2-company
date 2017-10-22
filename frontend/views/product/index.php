<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;
use common\models\Pages;

/* @var $this yii\web\View */
/* @var string $type */
/* @var array $tags */
/* @var $header \common\models\Pages */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = [
	'label' => $type,
	'url' => ['/product'],
];
if ($searchModel->category) {
	$this->params['breadcrumbs'][] = [
		'label' => $searchModel->category,
		'url' => ['/product', 'PagesSearch[category]' => $searchModel->category],
	];
}
?>
<style>
    .checkbox-input {
        max-height: 300px;
        overflow: auto
    }

    .checkbox-input label {
        margin-right: 15px;
    }

    .category-menu li.active a {
        color: #fff
    }

    .product {
        height: 400px;
        overflow: auto;
    }
</style>
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Our Products</h1>
            </div>
            <div class="col-md-5">
				<?= Breadcrumbs::widget([
					'links' => $this->params['breadcrumbs'],
				]); ?>
            </div>
        </div>
    </div>
</div>

<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">

                <p class="text-muted lead">
					<?= HtmlPurifier::process($header->description) ?>
                </p>

				<?php
				Pjax::begin();
				echo ListView::widget([
					'dataProvider' => $dataProvider,
					'itemView' => '_list',
					'layout' => "<div class='row products'>{items}</div>{pager}",
					'itemOptions' => [
						'class' => 'col-md-4 col-sm-6'
					]
				]);
				Pjax::end();
				?>
            </div>
            <div class="col-sm-3">
		        <?php $form = ActiveForm::begin([
			        'action' => ['index'],
			        'method' => 'get',
		        ]); ?>
                <div class="panel panel-default sidebar-menu">
                    <div class="panel-body">
                        <div class=""></div>
				        <?= $form->field($searchModel, 'key', ['template' => "{input}\n{hint}\n{error}"])->textInput(['placeholder' => 'Search ...']) ?>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">Categories</h3>
                    </div>

                    <div class="panel-body">
                        <ul class="nav nav-stacked category-menu">
					        <?php foreach (Pages::getAvailableTags(Pages::PAGE_ATTRIBUTE_CATEGORY) as $category) : ?>
                                <li class="<?php if ($searchModel->category == $category) echo 'active bg-primary' ?>">
							        <?= Html::a($category, ['/product', 'PagesSearch[category]' => $category]) ?>
                                </li>
					        <?php endforeach ?>
                        </ul>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">Tags</h3>
                        <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> <span
                                    class="hidden-sm">Clear</span></a>
                    </div>
                    <div class="panel-body" id="tags-container">
				        <?= $form->field($searchModel, 'tags', [
					        'template' => "<div class='checkbox-input'>{input}</div>{hint}\n{error}",
				        ])->checkboxList(Pages::getAvailableTags()) ?>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">Color</h3>
                        <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> <span
                                    class="hidden-sm">Clear</span></a>
                    </div>
                    <div class="panel-body" id="color-container">
				        <?= $form->field($searchModel, 'color', [
					        'template' => "<div class='checkbox-input'>{input}</div>{hint}\n{error}",
				        ])->checkboxList(Pages::getColors()) ?>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">Size</h3>
                        <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> <span
                                    class="hidden-sm">Clear</span></a>
                    </div>
                    <div class="panel-body" id="size-container">
				        <?= $form->field($searchModel, 'size', [
					        'template' => "<div class='checkbox-input'>{input}</div>{hint}\n{error}",
				        ])->checkboxList(Pages::getSizes()) ?>
                    </div>
                </div>

                <div class="form-group">
			        <?= Html::submitButton('<i class="fa fa-pencil"></i> Search', ['class' => 'btn btn-default btn-sm btn-template-main']) ?>
                </div>
		        <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
