<?php
/**
 * Created by PhpStorm.
 * User: bayu
 * Date: 4/28/17
 * Time: 11:00 AM
 *
 * @var $model \frontend\models\ContactForm
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<section id="contact">
    <div class="container">
        <h2 class="section-heading text-center">Contact Us</h2>
        <?php $form = ActiveForm::begin(['id' => 'contact-form', 'action' => ['/contact'],]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php if (\Yii::$app->user->isGuest) : ?>
                    <div class="form-group">
                        <?= Html::activeTextInput($model, 'name', ['placeholder' => Yii::t('app', 'Name'), 'class' => 'form-control']) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::activeTextInput($model, 'email', ['placeholder' => Yii::t('app', 'Email'), 'class' => 'form-control']) ?>
                    </div>
                <?php endif ?>
                <div class="form-group">
                    <?= Html::activeTextInput($model, 'subject', ['placeholder' => Yii::t('app', 'Subject'), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-lg', 'name' => 'contact-button']) ?>
                </div>
            </div>
            <div class="col-sm-6">
                <?= Html::activeTextarea($model, 'body', ['placeholder' => Yii::t('app', 'Body'), 'class' => 'form-control', 'rows' => 11]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</section>

