<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\UploadShippingMethod */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Upload Shipping Method');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shipping Method Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-shipping-method-cost-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="shipping-method-cost-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="panel panel-yellow">
            <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i><?=Yii::t('app','Upload')?></div>
            <div class="panel-body">
                <?= $form->field($model, 'name');?>
                <?= $form->field($model, 'excel')->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'application/vnd.ms-excel']);?>
                <?= $form->field($model, 'replace')->checkbox()?>
            </div>
            <div class="panel-footer">
                <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
