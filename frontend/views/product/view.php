<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $cartModel common\models\Cart */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
    <h1 class="page-header"><?= Html::decode($model->name) ?> <small><?= $model->category->name ?></small></h1>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <?= Html::img('http://placehold.it/320x150') ?>
            </div>
            <div class="col-md-8">
                <h4>
                    <?php if ($model->discount) : ?>
                        <?= Yii::$app->formatter->asCurrency($model->price) ?>
                        <small
                            class="label label-success"><?= Yii::$app->formatter->asPercent($model->discount / 100) ?></small>
                    <?php else : ?>
                        <?= Yii::$app->formatter->asCurrency($model->price) ?>
                    <?php endif ?>
                </h4>
                <div class="form-group">
                    <div>Stock: <?= $model->stock ?></div>
                </div>
                <?php if ($model->stock) :?>
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($cartModel, 'qty', [
                        'options' => ['class' => ''],
                        'template' => "
                            <div class='input-group' style='width: 200px'>
                                {input}
                                <div class='input-group-btn'>
                                    <button type='submit' class='btn btn-primary'>
                                        <i class='fa fa-shopping-cart'></i>
                                    </button>
                                </div>
                            </div>
                            \n{error}
                        ",
                    ])->input('number',[
                        'placeholder' => 'Quantity'
                    ]) ?>
                    <?=Html::activeHiddenInput($cartModel,'product_id',['value' => $model->id])?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => 'Description',
                    'content' => Html::tag('div', HtmlPurifier::process($model->description), ['class' => 'panel-body']),
                ],
                [
                    'label' => 'Reviews',
                    'content' => Html::tag('div', $this->render('_comment',['model' => $model]), ['class' => 'panel-body']),
                ],
            ],

        ]) ?>
    </div>
</div>
