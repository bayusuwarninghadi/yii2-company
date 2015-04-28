<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ShippingMethodCost */

$this->title = Yii::t('app', 'Create Shipping Method Cost');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shipping Method Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-method-cost-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
