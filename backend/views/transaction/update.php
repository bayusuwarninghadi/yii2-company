<?php

use common\models\Shipping;
use common\models\Transaction;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
/* @var $voucher \common\models\Voucher */
/* @var $shippingMethod array */

$this->title = 'Update Transaction: ' . ' ' . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->user->username;
$arrayStatus = Transaction::getStatusAsArray();
?>
<div class="transaction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'transaction-form',
        ]
    ]); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="pull-right">
                Status
                <div class="btn-group">
                    <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                        <?= $arrayStatus[$model->status] ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <?php foreach ($arrayStatus as $val => $status) : ?>
                            <li class="<?php if ($val == $model->status) echo 'active' ?>">
                                <a class="change-status" href="#" data-id="<?= $model->id ?>"
                                   data-status="<?= $val ?>"><?= $status ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
            <h5>
                <i class="fa fa-pencil fa-fw"></i> <?= 'Update' ?>
            </h5>

            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <h3 class="page-header"><?= $model->user->username ?>
                <small><?= Yii::$app->formatter->asEmail($model->user->email) ?> </small>
            </h3>
            <?= $form->field($model, 'shipping_id')->dropDownList(ArrayHelper::map(Shipping::findAll(['user_id' => $model->user_id]), 'id', 'address'))->hint('depends on user shipping address') ?>
            <?= $form->field($model, 'note')->textarea(['row' => 3]) ?>
            <?= $form->field($model, 'sub_total', [
                'template' => "
                    {label}
                    <div class='input-group'>
                        <span class='input-group-addon'>Rp</span>
                        {input}
                    </div>
                    \n{error}"
            ])->input('number') ?>

            <?= $form->field($model, 'grand_total', [
                'template' => "
                    {label}
                    <div class='input-group'>
                        <span class='input-group-addon'>Rp</span>
                        {input}
                    </div>
                    \n{error}"
            ])->input('number') ?>
            <?php
            $voucherValue = Yii::$app->formatter->asCurrency($voucher ? $voucher->value : 0);
            echo $form->field($model, 'voucher_code', [
                'template' => "
                    {label}
                    <div class='input-group'>
                        <span class='input-group-addon'>$voucherValue</span>
                        {input}
                    </div>
                    \n{error}"
            ])->textInput() ?>
            <?=$form->field($model, 'shipping_method_id')->dropDownList($shippingMethod)?>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?= $this->render('_cart', [
        'dataProvider' => new ActiveDataProvider([
            'sort' => false,
            'query' => $model->getCarts(),
        ])
    ]) ?>
    <?= $this->render('_confirmation', [
        'dataProvider' => new ActiveDataProvider([
            'sort' => false,
            'query' => $model->getConfirmations(),
        ])
    ]) ?>
</div>
