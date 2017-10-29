<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;
use common\models\Pages;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

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
    foreach ($searchModel->category as $category){
	    $this->params['breadcrumbs'][] = [
		    'label' => $category,
		    'url' => ['/product', 'PagesSearch[category]' => $category],
	    ];
    }
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
                                    <li class="<?php if (in_array($category, $searchModel->category)) echo 'active' ?>">
                                        <a href="#">
                                            <input type="checkbox" class="hidden" name="PagesSearch[category][]" value="<?=$category?>" <?php if (in_array($category, $searchModel->category)) echo 'checked="checked"' ?>>
                                            <?= $category ?>
                                        </a>
                                    </li>
								<?php endforeach ?>
                            </ul>
                        </div>
                        <div class="panel-heading">
                            <h3 class="panel-title">Brand</h3>
                            <button type='button'
                                    class='btn btn-xs btn-danger pull-right'
                                    data-container-target='#brand-container'
                                    data-toggle='checkbox'>
                                <i class="fa fa-times-circle"></i>
                                <span class="hidden-sm">Clear</span>
                            </button>
                        </div>
                        <div class="panel-body" id="brand-container">
		                    <?= $form->field($searchModel, 'brand_id', [
			                    'template' => "<div class='checkbox-input'>{input}</div>{hint}\n{error}",
		                    ])->checkboxList(ArrayHelper::map(Pages::findAll(['type_id' => Pages::TYPE_BRAND]), 'id', 'title')) ?>
                        </div>
                        <div class="panel-heading">
                            <h3 class="panel-title">Tags</h3>
                            <button type='button'
                                    class='btn btn-xs btn-danger pull-right'
                                    data-container-target='#tags-container'
                                    data-toggle='checkbox'>
                                <i class="fa fa-times-circle"></i>
                                <span class="hidden-sm">Clear</span>
                            </button>
                        </div>
                        <div class="panel-body" id="tags-container">
                            <ul class="tag-cloud category-menu">
	                            <?php foreach (Pages::getAvailableTags() as $tag) : ?>
                                    <li class="<?php if (in_array($tag, $searchModel->tags)) echo 'active' ?>">
                                        <a href="#">
                                            <input type="checkbox" class="hidden" name="PagesSearch[tags][]" value="<?=$tag?>" <?php if (in_array($tag, $searchModel->tags)) echo 'checked="checked"' ?>>
                                            <i class="fa fa-tags"></i> <?= Inflector::camel2words($tag) ?>
                                        </a>
                                    </li>
	                            <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="panel-body">
		                    <?= $form->field($searchModel, 'has_discount', [
			                    'template' => "<div class='checkbox-input'>{input}</div>{hint}\n{error}",
		                    ])->checkbox() ?>
                        </div>
                        <div class="panel-heading">
                            <h3 class="panel-title">Color</h3>
                            <button type='button'
                                    class='btn btn-xs btn-danger pull-right'
                                    data-container-target='#color-container'
                                    data-toggle='checkbox'>
                                <i class="fa fa-times-circle"></i>
                                <span class="hidden-sm">Clear</span>
                            </button>
                        </div>
                        <div class="panel-body" id="color-container">
							<?= $form->field($searchModel, 'color', [
								'template' => "<div class='checkbox-input'>{input}</div>{hint}\n{error}",
							])->checkboxList(Pages::getColors()) ?>
                        </div>
                        <div class="panel-heading">
                            <h3 class="panel-title">Size</h3>
                            <button type='button'
                                    class='btn btn-xs btn-danger pull-right'
                                    data-container-target='#size-container'
                                    data-toggle='checkbox'>
                                <i class="fa fa-times-circle"></i>
                                <span class="hidden-sm">Clear</span>
                            </button>
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
<?=$this->registerJs("
        $('.category-menu a').click(function (ev) {
            var _parent = $(this).closest('li');
            _parent.toggleClass('active');
            _parent.find('input[type=\"checkbox\"]').prop(\"checked\", _parent.hasClass('active'));
            return false;
        })
")?>