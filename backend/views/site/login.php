<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
?>
<div class="site-login">
    <div class="panel panel-red">
        <div class="panel-heading">
            <div class="panel-header"><h4><?= Html::encode($this->title) ?></h4></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <div class="form-group">
                        <i class="fa fa-lock fa-4x text-danger"></i>
                    </div>
                    <p class="text-muted">Please fill out the following fields to login:</p>
                </div>
                <div class="col-sm-8">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <?= $form->field($model, 'username', ['inputOptions' => ['placeholder' => 'Username']])->label(false) ?>
                        <?= $form->field($model, 'password', ['inputOptions' => ['placeholder' => 'Password']])->passwordInput()->label(false) ?>
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        <div class="form-group">
                            <?= Html::submitButton('Login', ['class' => 'btn btn-danger', 'name' => 'login-button']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
