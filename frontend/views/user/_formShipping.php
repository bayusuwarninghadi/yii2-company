<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Province;
use common\models\City;
use common\models\CityArea;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/19/15
 * Time: 23:14
 *
 * @var $this \yii\web\View
 * @var $form yii\widgets\ActiveForm
 * @var $model \common\models\Shipping
 */
?>
<div class="article-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <i class="fa fa-pencil fa-fw"></i>
            <?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update') ?>
        </div>
        <div class="panel-body">
            <?= $form->field($model, 'address')->textarea(['row' => 3]) ?>
            <?= $form->field($model, 'province_id')->dropDownList(
                ArrayHelper::map(Province::find()->all(),'id','name'),
                [
                    'data' => [
                        'dynamic' => 'true',
                        'child' => Html::getInputId($model,'city_id'),
                        'url' => Url::to(['/user/dynamic-dropdown','model' => 'city'])
                    ]
                ]) ?>
            <?= $form->field($model, 'city_id')->dropDownList(
                ArrayHelper::map(City::findAll(['province_id' => $model->province_id]),'id','name'),
                [
                    'data' => [
                        'dynamic' => 'true',
                        'child' => Html::getInputId($model,'city_area_id'),
                        'url' => Url::to(['/user/dynamic-dropdown','model' => 'city_area'])
                    ]
                ]) ?>
            <?= $form->field($model, 'city_area_id')->dropDownList(ArrayHelper::map(CityArea::findAll(['city_id' => $model->city_id]),'id','name')) ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>