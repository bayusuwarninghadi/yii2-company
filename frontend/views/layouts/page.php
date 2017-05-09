<?php
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model \common\models\Pages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section bg-light-gray">
    <div class="container">
        <?=HtmlPurifier::process($model->description)?>
    </div>

</section>
