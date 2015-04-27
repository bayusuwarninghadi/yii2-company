<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\User */

$this->title = Yii::t('yii', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('yii', 'Please fill out the following fields to signup:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'disclaimer')->checkbox()->label(Yii::t('yii', 'I agree to the our') . ' ' . Html::a(Yii::t('yii', 'Terms And Condition'), '/site/terms')) ?>
            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                <?= Yii::t('yii', 'Have Account?') ?> <?= Html::a(Yii::t('yii', 'Login'), ['site/login']) ?>.
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
