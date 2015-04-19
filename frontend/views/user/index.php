<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update row">
    <div class="col-md-5 col-sm-8">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'image', [
            'template' => Html::tag('div', UploadHelper::getHtml('user/' . $model->id, 'small')) .
                "{label}\n{input}\n{hint}\n{error}"
        ])->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'image/*']); ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>
