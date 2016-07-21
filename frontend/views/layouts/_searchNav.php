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
<ul class="navbar-form navbar-nav nav hidden visible-lg">
    <li class="navigation-search">
        <?php $form = ActiveForm::begin(['action' => ['/content'], 'method' => 'get']) ?>
        <div class="input-group">
            <?= Html::textInput('PagesSearch[key]', null, ['class' => 'form-control', 'placeholder' => \Yii::t('app', 'Search')]) ?>
            <span class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
        </div>
        <?php ActiveForm::end() ?>
    </li>
</ul>

