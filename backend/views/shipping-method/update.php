<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShippingMethodCost */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Shipping Method Cost',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shipping Method Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->shippingMethod->name . ' - ' . $model->cityArea->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="shipping-method-cost-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
