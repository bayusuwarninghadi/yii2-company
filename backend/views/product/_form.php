<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Product;
use backend\widget\tinymce\TinyMce;
use backend\widget\CategoryWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?=$model->isNewRecord ? 'Create' : 'Update'?></div>
        <div class="list-group-item">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'description')->widget(TinyMce::className(), Yii::$app->modules['tiny-mce']) ?>            
            <?= $form->field($model, 'cat_id',['template' => "{input}\n{hint}\n{error}"])->widget(CategoryWidget::className())?>
            <?= $form->field($model, 'price')->input('number') ?>
            <?= $form->field($model, 'discount')->input('number') ?>
            <?= $form->field($model, 'stock')->input('number') ?>
            <?= $form->field($model, 'status')->dropDownList(Product::getStatusAsArray()) ?>
            <?= $form->field($model, 'visible')->dropDownList(Product::getVisibleAsArray()) ?>
            <?= $form->field($model, 'order')->input('number') ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
