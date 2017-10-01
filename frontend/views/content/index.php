<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use backend\widget\category\CategoryWidget;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="row">
        <div class="product-search col-md-3 hidden-xs">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>

            <div class="panel panel-default" id="product-search">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= \Yii::t('app', 'Search') ?></h3>
                </div>
                <?= $form->field($searchModel, 'cat_id', ['template' => "{input}\n{hint}\n{error}", 'options' => ['class' => '']])->widget(CategoryWidget::className(), ['withPanel' => false]) ?>
                <div class="panel-body">
                    <?= $form->field($searchModel, 'key') ?>
                </div>
                <div class="panel-footer">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>


        </div>
        <div class="col-md-9">
            <?php
            Pjax::begin();
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list',
                'layout' => "{items}{pager}",
                'itemOptions' => [
                    'class' => 'media'
                ]
            ]);
            Pjax::end();
            ?>

        </div>
    </div>
</div>
