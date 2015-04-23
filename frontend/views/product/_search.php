<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\category\CategoryWidget;
use yii\helpers\ArrayHelper;
use common\models\Brand;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-search"></i> Advance Search
        </div>
        <?= $form->field($model, 'cat_id', ['template' => "{input}\n{hint}\n{error}", 'options' => ['class' => '']])->widget(CategoryWidget::className(),['withPanel' => false])?>
        <div class="panel-body">
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brand::find()->all(), 'id', 'brand'), ['prompt' => 'Select Brand']) ?>
            <?= $form->field($model, 'price_from')->input('number') ?>
            <?= $form->field($model, 'price_to')->input('number') ?>
            <div class="form-group">
                <label class="control-label" for="sort">Sort</label>
                <?=Html::dropDownList('sort',Yii::$app->request->get('sort'),[
                    'price' => 'Price Lowest To High',
                    '-price' => 'Price Highest To Low',
                    'discount' => 'Discount Lowest To High',
                    '-discount' => 'Discount Highest To Low',
                ],[
                    'class' => 'form-control',
                    'prompt' => 'Select Sort'
                ])?>
            </div>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
