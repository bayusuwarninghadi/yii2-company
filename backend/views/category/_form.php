<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?=$model->isNewRecord ? 'Create' : 'Update'?></div>
        <div class="panel-body">
	        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
	        <?= $form->field($model, 'description')->widget(TinyMce::className(), Yii::$app->modules['tiny-mce']) ?>            
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
