<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'ADMIN LOGIN';
?>
<div class="site-login">
    <div class="text-center text-danger" style="font-size: 30px; margin: 0 0 10px"><?= Html::encode($this->title) ?></div>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <div class="form-group">
                        <i class="fa fa-lock fa-5x text-danger"></i>
                    </div>
                    <p>Please fill out the following fields to login:</p>
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
