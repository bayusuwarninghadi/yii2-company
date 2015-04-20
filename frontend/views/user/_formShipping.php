<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
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
    <div class="panel">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?=$model->isNewRecord ? 'Create' : 'Update'?></div>
        <div class="panel-body">
            <?= $form->field($model, 'address')->textarea(['row' => 3]) ?>
            <?= $form->field($model, 'city')->textInput(['maxlength' => 50]) ?>
            <?= $form->field($model, 'postal_code')->textInput(['maxlength' => 5]) ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>