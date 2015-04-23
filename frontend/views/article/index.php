<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Html::submitButton('Search', ['class' => 'btn btn-default pull-right']) ?>
            <h5>Search</h5>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($searchModel, 'title') ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($searchModel, 'description') ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
        'layout' => "{items}<hr/>{summary}\n{pager}",
        'itemOptions' => [
            'class' => 'list-group-item'
        ]

    ]); ?>


</div>
