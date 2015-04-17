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
    <p>
        <?= HTMLPurifier::process($model->description)?>
    </p>
    <small class="text-muted">
        <i class="fa fa-fw fa-calendar"></i> <?=Yii::$app->formatter->asDate($model->updated_at)?>
    </small>
</div>
