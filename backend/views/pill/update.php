<?php

use yii\helpers\Html;
use backend\widget\tinymce\TinyMce;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
use common\assets\FontAwesomeAsset;

/* @var string $type */
/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $modelEnglish common\models\PagesLang */
/* @var $modelIndonesia common\models\PagesLang */


$this->title = 'Update ' . $type . ': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="article-form">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="panel panel-yellow">
            <div class="panel-heading"><i
                        class="fa fa-pencil fa-fw"></i> <?= $model->isNewRecord ? 'Create' : 'Update' ?>
            </div>
            <div class="panel-body">

				<?php
				$tinyMceConfig = \Yii::$app->modules['tiny-mce'];
				$items = [];

				$tinyMceConfig['options']['name'] = 'modelEnglish[description]';
				$items[] = [
					'label' => 'English',
					'content' =>
						$form->field($modelEnglish, 'title')->textInput(['maxlength' => 255, 'name' => 'modelEnglish[title]']) .
						$form->field($modelEnglish, 'description')->widget(TinyMce::className(), $tinyMceConfig),
				];
				$tinyMceConfig['options']['name'] = 'modelIndonesia[description]';
				$items[] = [
					'label' => 'Indonesia',
					'content' =>
						$form->field($modelIndonesia, 'title')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[title]']) .
						$form->field($modelIndonesia, 'description')->widget(TinyMce::className(), $tinyMceConfig),
				];


				echo Tabs::widget([
					'items' => $items
				]);
				?>
                <div class="field-pages-icon">
                    <label class="control-label" for="pages-label_1">Icon</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i id="drop-icon" class="fa fa-lg <?= $model->subtitle ?>"
                               data-current="<?= $model->subtitle ?>"></i>
                        </div>
						<?= Html::activeTextInput($model, 'subtitle', ['value' => $model->subtitle, 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                        <div class="input-group-btn">
                            <a href="#" class="btn btn-default" data-toggle="modal"
                               data-target="#selectorModal">Change</a>
                        </div>
                    </div>
                </div>
				<?= $form->field($model, 'order')->input('number') ?>
            </div>
            <div class="panel-footer">
				<?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
		<?php ActiveForm::end(); ?>
    </div>
</div>

<div class="modal fade" id="selectorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Select Icon</h4>
            </div>
            <div class="modal-body">
                <div id="icon-search">
                    <div class="form-group">
						<?= Html::label('Select Icon', 'icon-search') ?>
						<?= Html::input('text', 'icon-search', '', ['class' => 'form-control', 'placeholder' => 'Select our favorite icons']) ?>
                    </div>
                    <div class="icon-container container-fluid">
                        <div class="row">
							<?php foreach (FontAwesomeAsset::listFont() as $icon) : ?>
                                <div class="col-xs-3 col-sm-2 icon" data-toggle="tooltip" data-title="<?= $icon ?>">
                                    <button class="selector btn btn-default btn-block"
                                            data-target-input="#pages-subtitle"
                                            data-target-icon="#drop-icon"
                                    >
                                        <i class="fa fa-3x <?= $icon ?>"></i>
                                        <i class="icon-text"><?= $icon ?></i>
                                    </button>
                                </div>
							<?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>