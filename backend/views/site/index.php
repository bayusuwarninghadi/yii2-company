<?php
use yii\helpers\Html;
use backend\widget\chart\Morris;

/* @var $this yii\web\View */
/* @var $requestChart array */
/* @var $transactionChart array */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?=$this->render('_dashboardTop',[])?>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">TransactionHistory</h3>
            </div>
            <div class="panel-body">
                <?= Morris::widget($transactionChart)?>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <h3 class="panel-title">Api Request</h3>
            </div>
            <div class="panel-body">
                <?= Morris::widget($requestChart)?>
            </div>
        </div>
    </div>
</div>
