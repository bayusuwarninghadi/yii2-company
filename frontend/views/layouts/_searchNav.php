<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/23/15
 * Time: 02:01
 */
$model = new \common\models\ProductSearch();
?>
<li class="navigation-search">
    <?php $form = ActiveForm::begin([ 'action' => ['product/index'],'method' => 'get'])?>
    <div class="input-group">
        <?=Html::activeTextInput($model,'name',['class' => 'form-control', 'placeholder' => 'Search Product...'])?>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </span>
    </div>
    <?php ActiveForm::end()?>
</li>