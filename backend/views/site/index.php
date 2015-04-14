<?php
use yii\helpers\Html;
use backend\widget\chart\Morris;

/* @var $this yii\web\View */
/* @var $chart array */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?=$this->render('_dashboardTop',[])?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Api Request</h3>
	</div>
	<div class="panel-body">
	    <?= Morris::widget($chart)?>
	</div>
</div>