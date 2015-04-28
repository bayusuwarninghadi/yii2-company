<?php
use backend\widget\chart\Morris;
use common\models\Transaction;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $requestChart array */
/* @var $transactionChart array */
/* @var $transactionDataProvider \yii\data\ActiveDataProvider */
/* @var $userDataProvider \yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_dashboardTop', [
    'requestChart' => $requestChart
]) ?>
<div class="panel panel-green">
    <div class="panel-heading">
        <h3 class="panel-title">Overview</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-7 col-sm-6">
                <h3 class="text-center">Last Transaction Activity</h3>
                <?= Morris::widget($transactionChart) ?>
            </div>
            <div class="col-md-5 col-sm-6">
                <h4>Last Transaction Activity</h4>
                <?= GridView::widget([
                    'dataProvider' => $transactionDataProvider,
                    'rowOptions' => function ($model) {
                        switch ($model->status) {
                            case (int)Transaction::STATUS_USER_PAY;
                                $class = 'warning';
                                break;
                            default;
                                $class = '';
                                break;
                        }
                        return ['class' => $class];
                    },
                    'layout' => '{items}',
                    'columns' => [
                        'user.username',
                        'shipping.city',
                        'grand_total:currency',
                    ],
                ]); ?>
                <h4>Last Registered User</h4>
                <?= GridView::widget([
                    'dataProvider' => $userDataProvider,
                    'layout' => '{items}',
                    'columns' => [
                        'username',
                        'email',
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
