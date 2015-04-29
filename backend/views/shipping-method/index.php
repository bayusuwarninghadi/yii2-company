<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\helpers\ArrayHelper;
use common\models\ShippingMethod;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ShippingMethodCostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shipping Costs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-method-cost-index">

    <h1>
        <?=Html::a('<i class="fa fa-plus fa-fw"></i> Shipping Cost', ['create'], ['class' => 'btn btn-default pull-right'])?>
        <?= Html::encode($this->title) ?>
    </h1>

    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Province',
                'attribute' => 'province_name',
                'value' => 'cityArea.city.province.name'
            ],
            [
                'label' => 'City',
                'attribute' => 'city_name',
                'value' => 'cityArea.city.name'
            ],
            [
                'label' => 'City Area',
                'attribute' => 'city_area_name',
                'value' => 'cityArea.name'
            ],
            [
                'label' => 'Method',
                'filter' => ArrayHelper::map(ShippingMethod::find()->all(),'id','name'),
                'attribute' => 'shipping_method_id',
                'value' => 'shippingMethod.name'
            ],
            'value:currency',
            'estimate_time',

            ['class' => 'backend\widget\ActionColumn'],
        ],
    ]);
    Pjax::end();
    ?>

</div>
