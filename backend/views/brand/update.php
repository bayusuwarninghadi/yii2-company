<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */

$this->title = 'Update Brand: ' . ' ' . $model->brand;
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->brand;
?>
<div class="brand-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
