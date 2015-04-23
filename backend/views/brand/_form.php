<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\UploadHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?=$model->isNewRecord ? 'Create' : 'Update'?></div>
        <div class="panel-body">
            <?= $form->field($model, 'image',[
                'template' => Html::tag('div', UploadHelper::getHtml('brand/' . $model->id, 'medium',[],true)) .
                    "{label}\n{input}\n{hint}\n{error}"
            ])->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'image/*']);?>
            <?= $form->field($model, 'brand')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>