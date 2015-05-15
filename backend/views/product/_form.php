<?php

use backend\widget\category\CategoryWidget;
use backend\widget\tinymce\TinyMce;
use common\models\Brand;
use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $attributes array */
/* @var $modelEnglish common\models\ProductLang */
/* @var $modelIndonesia common\models\ProductLang */

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?= $model->isNewRecord ? 'Create' : 'Update' ?>
        </div>
        <div class="list-group-item">
            <?= $form->field($model, 'images[]')->fileInput(['multiple' => '', 'class' => 'form-control btn btn-default', 'accept' => 'image/*']) ?>
            <?= $form->field($model, 'cat_id', ['template' => "{input}\n{hint}\n{error}"])->widget(CategoryWidget::className()) ?>
            <?php

            $tinyMceConfig = Yii::$app->modules['tiny-mce'];
            $items = [];

            $tinyMceConfig['options']['name'] = 'modelEnglish[description]';
            $items[] = [
                'label' => 'English',
                'content' =>
                    $form->field($modelEnglish, 'name')->textInput(['maxlength' => 255, 'name' => 'modelEnglish[name]']) .
                    $form->field($modelEnglish, 'subtitle')->textInput(['maxlength' => 255, 'name' => 'modelEnglish[subtitle]']) .
                    $form->field($modelEnglish, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];
            $tinyMceConfig['options']['name'] = 'modelIndonesia[description]';
            $items[] = [
                'label' => 'Indonesia',
                'content' =>
                    $form->field($modelIndonesia, 'name')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[name]']) .
                    $form->field($modelIndonesia, 'subtitle')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[subtitle]']) .
                    $form->field($modelIndonesia, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];

            echo Tabs::widget([
                'items' => $items
            ]);
            ?>
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
                                <?= $form->field($model, 'productDetail[' . $name . ']', [
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
