<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <div class="row">
        <div class="article-search col-md-3 hidden-xs">
            <div class="panel panel-default" id="article-search" >
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>
                <div class="panel-heading">
                    <h3 class="panel-title"><?=\Yii::t('app','Search')?></h3>
                </div>
                <div class="panel-body">
                    <?= $form->field($searchModel, 'key') ?>
                </div>
                <div class="panel-footer">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="col-md-9">
            <div class="container-fluid">
                <?php
                Pjax::begin();
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_list',
                    'options' => ['class' => 'grid row'],
                    'layout' => "{items}{pager}",
                    'itemOptions' => [
                        'class' => 'grid-item col-sm-3'
                    ]
                ]);
                Pjax::end();
                ?>
            </div>

        </div>

    </div>


</div>
