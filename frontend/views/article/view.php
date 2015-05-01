<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var string $this */
/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var string $type */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <?= HTMLPurifier::process($model->description) ?>
            </div>
        </div>
        <div class="panel-footer">
            <div class="form-group">
                <span class="pull-right">
                    <i class="fa fa-fw fa-calendar"></i> <?= Yii::$app->formatter->asDate($model->updated_at) ?>
                </span>
                <?= Html::a('<i class="fa fa-facebook fa-fw fa-lg"></i>', 'http://www.facebook.com/sharer.php?u=' . Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-primary btn-circle']) ?>
                <?= Html::a('<i class="fa fa-twitter fa-fw fa-lg"></i>', 'http://twitter.com/share?url=' . Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-info btn-circle']) ?>
                <?= Html::a('<i class="fa fa-google-plus fa-fw fa-lg"></i>', 'https://plus.google.com/share?url=' . Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-danger btn-circle']) ?>
                <?= Html::a('<i class="fa fa-envelope fa-fw fa-lg"></i>', 'mailto:?Subject='.Html::decode($model->title).'&body=' . Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-warning btn-circle']) ?>
                <div class="clearfix"></div>
            </div>

        </div>
    </div>

    <h3><?=Yii::t('app','User Comment(s)')?></h3>
    <div class="user-comment-view list-group-item">
        <?=Html::tag('div', $this->render('/layouts/_loading'), [
            'class' => 'comment-container',
            'data-id' => $model->id,
            'data-key' => 'article'
        ])?>
    </div>
</div>