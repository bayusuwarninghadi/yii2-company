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
<div class="user-update row">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-sm-6">
        <div class="panel">
            <div class="panel-heading">Update Profile</div>
        	<div class="panel-body">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($model, 'image', [
                    'template' => Html::tag('div', UploadHelper::getHtml('user/' . $model->id, 'small')) .
                        "{label}\n{input}\n{hint}\n{error}"
                ])->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'image/*']); ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
        	</div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Shipping</div>
            <?php if ($model->shippings) :?>
                <?php foreach ($model->shippings as $shipping) :?>
                    <div class="list-group-item">
                        <div class="pull-right">
                            <?=Html::a('Edit',['update-shipping','id' => $shipping->id])?>
                            <?=Html::a('Delete',['delete-shipping','id' => $shipping->id],[
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ])?>
                        </div>
                        <div class="list-group-item-heading"><?=$shipping->city?></div>
                        <?=Html::decode($shipping->address)?> <?=$shipping->postal_code?>
                    </div>
                <?php endforeach ?>
            <?php else :?>
                <div class="list-group-item">
                    You Don't Have Shipping Address, this is required for checkout
                </div>
            <?php endif ?>
            <div class="panel-footer">
                <?=Html::a('Create New Shipping Address',['create-shipping'],['class' => 'btn btn-success'])?>
            </div>
        </div>
    </div>
</div>
