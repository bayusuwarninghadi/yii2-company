<?php

use backend\widget\tinymce\TinyMce;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\UploadHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Inflector;
use common\models\Pages;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $modelEnglish common\models\PagesLang */
/* @var $modelIndonesia common\models\PagesLang */
/* @var $form yii\widgets\ActiveForm */
/* @var string $type */

?>

<div class="product-form">
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?= $model->isNewRecord ? 'Create' : 'Update' ?>
        </div>
        <div class="panel-body">
			<?php if (isset($model->pageImages)) : ?>
                <div class="row product-gallery text-center">
					<?php foreach ($model->pageImages as $key => $image) : ?>
						<?php $availableImages = Json::decode($image->value) ?>
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"
                             data-url="<?= $availableImages['medium'] ?>"
                             data-product="<?= $model->id ?>"
                             data-id="<?= $image->id ?>">
                            <div class="gallery-container active">
                                <div class="gallery"
                                     style="background-image: url(<?= UploadHelper::getImageUrl('page/' . $model->id . '/' . $image->id, 'medium') ?>)">
                                </div>
                            </div>
                            <a href="<?= Url::to(['delete-attribute', 'id' => $image->id]) ?>"
                               class="btn btn-danger btn-sm">
                                <i class="fa fa-trash-o"></i> Delete
                            </a>
                        </div>
					<?php endforeach ?>
                </div>
                <br>
			<?php endif ?>
			<?= $form->field($model, 'images[]')->fileInput(['multiple' => '', 'class' => 'form-control btn btn-default', 'accept' => 'image/*']) ?>
			<?php
			$tinyMceConfig = \Yii::$app->modules['tiny-mce'];
			$items = [];

			$tinyMceConfig['options']['name'] = 'modelEnglish[description]';
			$items[] = [
				'label' => 'English',
				'content' =>
					$form->field($modelEnglish, 'title')->textInput(['maxlength' => 255, 'name' => 'modelEnglish[title]']) .
					$form->field($modelEnglish, 'subtitle')->textInput(['maxlength' => 255, 'name' => 'modelEnglish[subtitle]']) .
					$form->field($modelEnglish, 'description')->widget(TinyMce::className(), $tinyMceConfig),
			];
			$tinyMceConfig['options']['name'] = 'modelIndonesia[description]';
			$items[] = [
				'label' => 'Indonesia',
				'content' =>
					$form->field($modelIndonesia, 'title')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[title]']) .
					$form->field($modelIndonesia, 'subtitle')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[subtitle]']) .
					$form->field($modelIndonesia, 'description')->widget(TinyMce::className(), $tinyMceConfig),
			];


			echo Tabs::widget([
				'items' => $items
			]);
			?>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-3">
					<?= $form->field($model, 'brand_id')->dropDownList(
						ArrayHelper::map(Pages::findAll(['type_id' => Pages::TYPE_BRAND]), 'id', 'title')
					) ?>
					<?= $form->field($model, 'order')->input('number') ?>
					<?= $form->field($model, 'discount')->input('number') ?>
                </div>
                <div class="col-sm-4">
					<?= $form->field($model, 'category')->widget(Select2::classname(), [
						'data' => Pages::getAvailableTags(Pages::PAGE_ATTRIBUTE_CATEGORY),
						'options' => ['placeholder' => 'Select a category ...', 'multiple' => true],
						'pluginOptions' => [
							'tags' => true,
							'tokenSeparators' => [','],
						],
					]) ?>
					<?= $form->field($model, 'tags')->widget(Select2::classname(), [
						'data' => Pages::getAvailableTags(),
						'options' => ['placeholder' => 'Select a tags ...', 'multiple' => true],
						'pluginOptions' => [
							'tags' => true,
							'tokenSeparators' => [','],
						],
					]) ?>

					<?= $form->field($model, 'color')->widget(Select2::classname(), [
						'data' => Pages::getColors(),
						'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
						'pluginOptions' => [
							'tags' => true,
							'tokenSeparators' => [','],
						],
					]) ?>
					<?= $form->field($model, 'size')->widget(Select2::classname(), [
						'data' => Pages::getSizes(),
						'options' => ['placeholder' => 'Select a size ...', 'multiple' => true],
						'pluginOptions' => [
							'tags' => true,
							'tokenSeparators' => [','],
						],
					]) ?>
                </div>
                <div class="attribute col-sm-5" id="custom-detail">
                    <div class="text-right">
						<?= Html::a('Add New Specification', '#custom-detail', ['class' => 'btn btn-default btn-sm add-detail']) ?>
                    </div>
                    <div class="custom-detail">
						<?php foreach ($model->detail as $name => $detail) : ?>
							<?= $form->field($model, 'detail[' . $name . ']', [
								'template' => "
                                            <div class='input-group'>
                                                <span class='input-group-addon'>{label}</span>
                                                {input}
                                                <span class='input-group-btn'>
                                                    <a href='#' class='btn btn-danger btn-remove-detail'><i class='fa fa-trash-o'></i></a>
                                                </span>
                                            </div>
                                            \n{error}"
							])->textInput(['value' => $detail])->label(Inflector::camel2words($name)) ?>
						<?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
	<?php ActiveForm::end(); ?>
</div>
