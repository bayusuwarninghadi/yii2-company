<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
        <i class="fa fa-truck fa-fw"></i> <?= Yii::t('app', 'Detail') ?>
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
    <div class="panel-footer text-right">
        <?php
        $form = ActiveForm::begin(['action' => '/transaction/success']);
        echo Html::activeHiddenInput($model, 'user_id');
        echo Html::activeHiddenInput($model, 'shipping_id');
        echo Html::activeHiddenInput($model, 'note');
        echo Html::activeHiddenInput($model, 'sub_total');
        echo Html::activeHiddenInput($model, 'grand_total');
        echo Html::activeHiddenInput($model, 'payment_method');
        echo Html::activeHiddenInput($model, 'voucher_code');
        echo Html::activeHiddenInput($model, 'shipping_cost');
        echo Html::activeHiddenInput($model, 'shipping_method_id');
        echo Html::submitButton('Checkout', ['class' => 'btn btn-warning']);
        $form->end();
        ?>
    </div>
</div>
