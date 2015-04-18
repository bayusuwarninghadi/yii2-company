<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'image')->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'image/*']);?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

</div>
