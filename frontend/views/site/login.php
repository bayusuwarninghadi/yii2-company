<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('yii', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?=Yii::t('yii', 'Please fill out the following fields to login:')?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                <?= Yii::t('yii', 'If you forgot your password you can') ?> <?= Html::a(Yii::t('yii', 'reset it'), ['site/request-password-reset']) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?= Yii::t('yii', 'Not Have Account?') ?> <?= Html::a(Yii::t('yii', 'Register'), ['site/signup']) ?>.
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
