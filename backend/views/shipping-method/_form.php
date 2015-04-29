<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ShippingMethod;
use common\models\Province;
use common\models\City;
use common\models\CityArea;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $model common\models\ShippingMethodCost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shipping-method-cost-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?=$model->isNewRecord ? 'Create' : 'Update'?></div>
        <div class="panel-body">
            <?= $form->field($model, 'shipping_method_id')->dropDownList(ArrayHelper::map(ShippingMethod::find()->all(),'id','name')) ?>
            <?= $form->field($model, 'value')->textInput() ?>
            <?= $form->field($model, 'estimate_time')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'province_id')->dropDownList(ArrayHelper::map(Province::find()->all(),'id','name')) ?>
            <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(City::findAll(['province_id' => $model->province_id]),'id','name')) ?>
            <?= $form->field($model, 'city_area_id')->dropDownList(ArrayHelper::map(CityArea::findAll(['city_id' => $model->city_id]),'id','name')) ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJsFile('/js/shipping.js', ['depends' => JqueryAsset::className()])?>