<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ShippingMethodCost */

$this->title = $model->shippingMethod->name . ' - ' . $model->cityArea->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shipping Method Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-method-cost-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-green">
        <div class="panel-heading"><i class="fa fa-list fa-fw"></i> Detail</div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'shippingMethod.name',
                'value:currency',
                'estimate_time',
                'cityArea.city.province.name',
                'cityArea.city.name',
                'cityArea.name',
            ],
        ]) ?>
    </div>

</div>
