<?php
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model \common\models\Pages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-page">
    <?=HtmlPurifier::process($model->description)?>
</div>
