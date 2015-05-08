<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/28/15
 * Time: 22:31
 *
 * @var $model \common\models\Transaction
 * @var $this \yii\web\View
 * @var $cartDataProvider \yii\data\ActiveDataProvider
 */

?>
<h1><?= Yii::t('app', 'Transaction') . ' #' . $model->id ?></h1>
<div class="panel panel-success">
    <div class="panel-heading">
        <i class="fa fa-truck fa-fw"></i> <?= Yii::t('app', 'Detail') ?>
    </div>
    <?= ListView::widget([
        'dataProvider' => $cartDataProvider,
        'emptyTextOptions' => ['class' => 'list-group-item'],
        'itemView' => '/transaction/_list',
        'layout' => '{items}' . Html::tag('div', Yii::t('app','Sub Total') . ' ' . Yii::$app->formatter->asCurrency($model->sub_total), ['class' => 'list-group-item text-right strong']),
        'itemOptions' => [
            'class' => 'list-group-item'
        ],
        'options' => [
            'class' => 'cart-list list-group'
        ],
    ]);
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'payment_method',
            'shipping.address',
            'shipping.cityArea.name',
            'shipping.cityArea.city.name',
            'shipping.postal_code',
            'shippingMethod.name',
            'shipping_cost:currency',
            [
                'label' => Yii::t('app', 'Voucher'),
                'value' => ($model->voucher)
                    ?
                    Html::tag('h2', $model->voucher_code . ' <small class="line-through">' . Yii::$app->formatter->asCurrency($model->voucher->value) . '</small>')
                    : '',
                'format' => 'html'
            ],
            'note',
        ],
    ]);
    ?>
    <div class="panel-footer text-right">
        <h3>
            <small>
                <?= Yii::t('app', 'Grand Total') ?>
            </small>
            <?= Yii::$app->formatter->asCurrency($model->grand_total) ?>
        </h3>
    </div>
</div>
