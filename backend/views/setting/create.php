<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Setting;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Setting';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="setting-form">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'key')->textInput(['maxlength' => 255]) ?>

	    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

	    <?= $form->field($model, 'value')->dropDownList(Setting::getReadonlyAsArray()) ?>

	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>
