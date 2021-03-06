<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\tinymce\TinyMce;
use yii\bootstrap\Tabs;

/* @var string $type */
/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelEnglish common\models\PagesLang */
/* @var $modelIndonesia common\models\PagesLang */


$this->title = 'Update ' . $type . ': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="article-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="panel panel-yellow">
            <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?=$model->isNewRecord ? 'Create' : 'Update'?></div>
            <div class="panel-body">
	            <?php
	            $tinyMceConfig = \Yii::$app->modules['tiny-mce'];
	            $items = [];

	            $tinyMceConfig['options']['name'] = 'modelEnglish[description]';
	            $items[] = [
		            'label' => 'English',
		            'content' =>
			            $form->field($modelEnglish, 'description')->widget(TinyMce::className(), $tinyMceConfig),
	            ];
	            $tinyMceConfig['options']['name'] = 'modelIndonesia[description]';
	            $items[] = [
		            'label' => 'Indonesia',
		            'content' =>
			            $form->field($modelIndonesia, 'description')->widget(TinyMce::className(), $tinyMceConfig),
	            ];


	            echo Tabs::widget([
		            'items' => $items
	            ]);
	            ?>
            </div>
            <div class="panel-footer">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
