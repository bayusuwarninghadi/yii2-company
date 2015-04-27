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
        'id' => 'product-search'
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-search"></i> <?=Yii::t('yii','Advance Search')?>
        </div>
        <?= $form->field($model, 'cat_id', ['template' => "{input}\n{hint}\n{error}", 'options' => ['class' => '']])->widget(CategoryWidget::className(),['withPanel' => false])?>
        <div class="panel-body">
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brand::find()->all(), 'id', 'brand'), ['prompt' => Yii::t('yii','Select Brand')]) ?>
            <?= $form->field($model, 'price_from')->input('number') ?>
            <?= $form->field($model, 'price_to')->input('number') ?>
            <div class="form-group">
                <label class="control-label" for="sort">Sort</label>
                <?=Html::dropDownList('sort',Yii::$app->request->get('sort'),[
                    'price' => Yii::t('yii','Price Lowest To High'),
                    '-price' => Yii::t('yii','Price Highest To Low'),
                    'discount' => Yii::t('yii','Discount Lowest To High'),
                    '-discount' => Yii::t('yii','Discount Highest To Low'),
                ],[
                    'class' => 'form-control',
                    'prompt' => Yii::t('yii','Select Sort')
                ])?>
            </div>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton(Yii::t('yii','Search'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
