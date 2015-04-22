<?php

use backend\widget\category\CategoryWidget;
use common\models\Brand;
use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
        <?= $form->field($model, 'cat_id', ['template' => "{input}\n{hint}\n{error}", 'options' => ['class' => '']])->widget(CategoryWidget::className(), ['withPanel' => false]) ?>
        <div class="panel-body">
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brand::find()->all(), 'id', 'brand'), ['prompt' => 'Select Brand']) ?>
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
            <?= $form->field($model, 'status')->dropDownList(Product::getStatusAsArray(), ['prompt' => 'Select Status']) ?>
            <?= $form->field($model, 'visible')->dropDownList(Product::getVisibleAsArray(), ['prompt' => 'Select Visibility']) ?>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
