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
    <div class="row">
        <div class="article-search col-md-3 hidden-xs">
            <div class="panel panel-default" id="article-search" >
                <div class="panel-heading">
                    <h3 class="panel-title"><?=Yii::t('app','Search')?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                    ]); ?>
                    <?= $form->field($searchModel, 'title') ?>
                    <?= $form->field($searchModel, 'description') ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list',
                'layout' => "<p>{summary}</p>{items}{pager}",
                'itemOptions' => [
                    'class' => 'list-group-item'
                ]
            ]); ?>

        </div>
    </div>


</div>
