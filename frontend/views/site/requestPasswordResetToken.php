<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = \Yii::t('app', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section bg-light-gray">
    <div class="container">
        <h1 class="section-heading"><?= Html::encode($this->title) ?></h1>

        <h3 class="section-subheading text-muted">
	        <?=\Yii::t('app', 'Please fill out your email. A link to reset password will be sent there')?>
        </h3>
        <div class="row">
            <div class="col-lg-5">
	            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
	            <?= $form->field($model, 'email') ?>
                <div class="form-group">
		            <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                </div>
	            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</section>