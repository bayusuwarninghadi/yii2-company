<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/23/15
 * Time: 02:01
 *
 * @var $this \yii\web\View
 */


?>
<ul class="navbar-form navbar-right nav">
    <li class="navigation-search">
        <?php $form = ActiveForm::begin(['action' => ['product/index'], 'method' => 'get']) ?>
        <div class="input-group">
            <?= Html::textInput('ProductSearch[name]', null, ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Search Product...')]) ?>
            <span class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
        </div>
        <?php ActiveForm::end() ?>
    </li>
</ul>

