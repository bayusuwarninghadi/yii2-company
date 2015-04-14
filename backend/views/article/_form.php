<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?=$model->isNewRecord ? 'Create' : 'Update'?></div>
        <div class="panel-body">
		    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
		    <?= $form->field($model, 'description')->widget(TinyMce::className(), Yii::$app->modules['tiny-mce'])?>
		    <?= $form->field($model, 'order')->textInput() ?>
        </div>
        <div class="panel-footer">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
