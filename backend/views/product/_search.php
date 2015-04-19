<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\category\CategoryWidget;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-search"></i> Advance Search
        </div>
        <?= $form->field($model, 'cat_id', ['template' => "{input}\n{hint}\n{error}", 'options' => ['class' => '']])->widget(CategoryWidget::className(),['withPanel' => false])?>
        <div class="panel-body">
            <?= $form->field($model, 'name') ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'price_from')->input('number') ?>
                </div>
                <div class="col-sm-6">                
                    <?= $form->field($model, 'price_to')->input('number') ?>                
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'discount_from')->input('number') ?>
                </div>
                <div class="col-sm-6">                
                    <?= $form->field($model, 'discount_to')->input('number') ?>                
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'stock_from')->input('number') ?>
                </div>
                <div class="col-sm-6">                
                    <?= $form->field($model, 'stock_to')->input('number') ?>                
                </div>
            </div>
            <?= $form->field($model, 'status')->dropDownList(Product::getStatusAsArray(),['prompt' => 'Select Status']) ?>
            <?= $form->field($model, 'visible')->dropDownList(Product::getVisibleAsArray(),['prompt' => 'Select Visibility']) ?>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
