<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = \Yii::t('app', 'Reset password');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section bg-light-gray">
    <div class="container">
        <h1 class="section-heading"><?= Html::encode($this->title) ?></h1>

        <h3 class="section-subheading text-muted">
	        <?=\Yii::t('app', 'Please choose your new password:')?>
        </h3>
        <div class="row">
            <div class="col-lg-5">
	            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
	            <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
		            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>
	            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</section>
