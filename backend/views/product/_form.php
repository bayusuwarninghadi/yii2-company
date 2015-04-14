<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Product;
use backend\widget\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <div class="row">
        <div class="col-lg-9 col-md-8">
            <?= $form->field($model, 'description')->widget(TinyMce::className(), Yii::$app->modules['tiny-mce']) ?>            
        </div>
        <div class="col-lg-3 col-md-4">
            <?= $form->field($model, 'price')->input('number') ?>
            <?= $form->field($model, 'discount')->input('number') ?>
            <?= $form->field($model, 'stock')->input('number') ?>
            <?= $form->field($model, 'status')->dropDownList(Product::getStatusAsArray()) ?>
            <?= $form->field($model, 'visible')->dropDownList(Product::getVisibleAsArray()) ?>
            <?= $form->field($model, 'order')->input('number') ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>            
    <?php ActiveForm::end(); ?>
</div>
