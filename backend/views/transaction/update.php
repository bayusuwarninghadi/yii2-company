<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Transaction;
use yii\helpers\ArrayHelper;
use common\models\Shipping;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update Transaction: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="transaction-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="panel panel-yellow">
            <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?='Update'?></div>
            <div class="panel-body">
                <h3 class="page-header"><?=$model->user->username ?> <small><?=$model->user->email?> </small> </h3>
                <?= $form->field($model, 'shipping_id')->dropDownList(ArrayHelper::map(Shipping::findAll(['user_id' => $model->user_id]),'id','city')) ?>
                <?= $form->field($model, 'note')->textarea(['row' => 3]) ?>
                <?= $form->field($model, 'status')->dropDownList(Transaction::getStatusAsArray()) ?>
                <?= $form->field($model, 'sub_total',[
                    'template' => "
                    {label}
                    <div class='input-group'>
                        <span class='input-group-addon'>Rp</span>
                        {input}
                    </div>
                    \n{error}"

                ])->input('number') ?>

                <?= $form->field($model, 'grand_total',[
                    'template' => "
                    {label}
                    <div class='input-group'>
                        <span class='input-group-addon'>Rp</span>
                        {input}
                    </div>
                    \n{error}"

                ])->input('number') ?>
            </div>
            <div class="panel-footer">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
