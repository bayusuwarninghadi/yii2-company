<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ShippingMethodCost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shipping-method-cost-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shipping_method_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'estimate_time')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'city_area_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
