<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/28/15
 * Time: 22:31
 *
 * @var $model \common\models\Transaction
 * @var $this \yii\web\View
 * @var $cartDataProvider \yii\data\ActiveDataProvider
 * @var $subTotal integer
 */

$this->title = Yii::t('app', 'Summary');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<div class="panel panel-success">
    <div class="panel-heading">
        <?= Yii::t('app', 'Detail') ?>
    </div>
    <?= $this->render('cartAjax', [
        'dataProvider' => $cartDataProvider,
        'subTotal' => $subTotal
    ]) ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'payment_method',
            'shipping.address',
            'shipping.city',
            'shipping_method',
            'shipping.postal_code',
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
    <div class="panel-footer">
        <strong>
            <?= Yii::t('app', 'Grand Total') ?> <?= Yii::$app->formatter->asCurrency($model->grand_total) ?>
        </strong>
    </div>
</div>
