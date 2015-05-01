<?php

use backend\widget\category\CategoryWidget;
use backend\widget\tinymce\TinyMce;
use common\models\Brand;
use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $attributes array */

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?= $model->isNewRecord ? 'Create' : 'Update' ?>
        </div>
        <div class="list-group-item">
            <?= $form->field($model, 'images[]')->fileInput(['multiple' => '', 'class' => 'form-control btn btn-default', 'accept' => 'image/*']) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'subtitle')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'cat_id', ['template' => "{input}\n{hint}\n{error}"])->widget(CategoryWidget::className()) ?>
            <?= $form->field($model, 'description')->widget(TinyMce::className(), Yii::$app->modules['tiny-mce']) ?>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brand::find()->all(), 'id', 'brand'), ['prompt' => 'Select Brand']) ?>
                    <?= $form->field($model, 'price', [
                        'template' => "
                            {label}
                            <div class='input-group'>
                                <span class='input-group-addon'>Rp</span>
                                {input}
                            </div>
                            \n{error}"
                    ])->input('number') ?>
                    <?= $form->field($model, 'discount', [
                        'template' => "
                            {label}
                            <div class='input-group'>
                                {input}
                                <span class='input-group-addon'>%</span>
                            </div>
                            \n{error}"
                    ])->input('number') ?>
                    <?= $form->field($model, 'stock')->input('number') ?>
                    <?= $form->field($model, 'status')->dropDownList(Product::getStatusAsArray()) ?>
                    <?= $form->field($model, 'visible')->dropDownList(Product::getVisibleAsArray()) ?>
                    <?= $form->field($model, 'order')->input('number') ?>
                </div>
                <div class="attribute col-sm-8">
                    <div class="panel panel-primary" id="custom-detail">
                        <div class="panel-heading">
                            <h3 class="panel-title">Custom Details</h3>
                        </div>
                        <div class="panel-body custom-detail">
                            <?php foreach ($attributes as $name => $detail) : ?>
                                <?= $form->field($model, 'productAttributeDetailValue[' . $name . ']', [
                                    'template' => "
                                            <div class='input-group'>
                                                <span class='input-group-addon'>{label}</span>
                                                {input}
                                                <span class='input-group-btn'>
                                                    <a href='#' class='btn btn-danger btn-remove-detail'><i class='fa fa-trash-o'></i></a>
                                                </span>
                                            </div>
                                            \n{error}"
                                ])->textInput(['value' => $detail])->label(Inflector::camel2words($name)) ?>
                            <?php endforeach ?>
                        </div>
                        <div class="panel-footer">
                            <?= Html::a('Add New Specification', '#custom-detail', ['class' => 'btn btn-warning add-detail']) ?>
                        </div>
                    </div>
                    <h4 id="custom-detail"></h4>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
