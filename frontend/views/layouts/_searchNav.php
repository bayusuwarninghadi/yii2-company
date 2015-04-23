<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/23/15
 * Time: 02:01
 */
?>
<li class="navigation-search">
    <?php $form = ActiveForm::begin([ 'action' => ['product/index'],'method' => 'get'])?>
    <div class="input-group">
        <?=Html::textInput('ProductSearch[name]',null,['class' => 'form-control', 'placeholder' => 'Search Product...'])?>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
    </div>
    <?php ActiveForm::end()?>
</li>