<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="user-update row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?= Yii::t('app', 'Update Profile') ?></div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($model, 'image', [
                    'template' => Html::tag('div', UploadHelper::getHtml('user/' . $model->id, 'small')) .
                        "{label}\n{input}\n{hint}\n{error}"
                ])->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'image/*']); ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'phone', [
                    'template' => "
                    {label}
                    <div class='input-group'>
                        <span class='input-group-addon'>+62</span>
                        {input}
                    </div>
                    \n{error}"
                ])->textInput(['maxlength' => 32]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><?= Yii::t('app', 'Shipping Address') ?></div>
            <?php if ($model->shippings) : ?>
                <?php foreach ($model->shippings as $shipping) : ?>
                    <div class="list-group-item">
                        <div class="pull-right">
                            <?= Html::a(Yii::t('app', 'Edit'), ['update-shipping', 'id' => $shipping->id]) ?>
                            <?= Html::a(Yii::t('app', 'Delete'), ['delete-shipping', 'id' => $shipping->id], [
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                        <div class="list-group-item-heading"><?= $shipping->city ?></div>
                        <?= Html::decode($shipping->address) ?> <?= $shipping->postal_code ?>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="list-group-item">
                    <?= Yii::t('app', "You Don't Have Shipping Address, this is required for checkout") ?>
                </div>
            <?php endif ?>
            <div class="panel-footer">
                <?= Html::a(Yii::t('app', 'Create New Shipping Address'), ['create-shipping'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
