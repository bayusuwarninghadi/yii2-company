<?php
use yii\helpers\Html;
use backend\widget\chart\Morris;

/* @var $this yii\web\View */
/* @var $chart array */

$this->title = 'Dashboard';
?>
<h1 class="page-header"><?= Html::encode($this->title) ?></h1>
<div class="panel panel-primary">
      <div class="panel-heading">
            <h3 class="panel-title">Api Request</h3>
      </div>
      <div class="panel-body">
            <?= Morris::widget($chart)?>
      </div>
</div>