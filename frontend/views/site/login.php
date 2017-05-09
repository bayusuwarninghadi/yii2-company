<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = \Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section bg-light-gray">
    <div class="container">
        <h1 class="section-heading"><?= Html::encode($this->title) ?></h1>
        <h3 class="section-subheading text-muted">
		    <?=\Yii::t('app', 'Please fill out the following fields to login:')?>
        </h3>
        <div class="row">

            <div class="col-lg-5">
	            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
	            <?= $form->field($model, 'username') ?>
	            <?= $form->field($model, 'password')->passwordInput() ?>
	            <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
		            <?= \Yii::t('app', 'If you forgot your password you can') ?> <?= Html::a(\Yii::t('app', 'reset it'), ['site/request-password-reset']) ?>
                </div>
                <div class="form-group">
		            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
		            <?= \Yii::t('app', 'Not Have Account?') ?> <?= Html::a(\Yii::t('app', 'Register'), ['site/signup']) ?>.
                </div>
	            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</section>