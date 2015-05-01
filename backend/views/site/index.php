<?php
use backend\widget\chart\Morris;
use common\models\Transaction;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $requestChart array */
/* @var $transactionChart array */
/* @var $transactionDataProvider \yii\data\ActiveDataProvider */
/* @var $userDataProvider \yii\data\ActiveDataProvider */
/* @var $siteStats array */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?php foreach($siteStats as $pil) :?>
        <div class="col-sm-6 col-lg-3">
            <div class="panel <?=$pil['panelType']?>">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa <?=$pil['icon']?> fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?=$pil['count']?></div>
                            <div><?=$pil['label']?>!</div>
                        </div>
                    </div>
                </div>
                <a href="<?=$pil['url']?>">
                    <div class="panel-footer">
                        <span class="pull-left"><?=Yii::t('app','View Details')?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach ?>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Last Activity</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-7">
                <?= Morris::widget($requestChart) ?>
            </div>
            <div class="col-sm-5">
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
<div class="panel panel-green">
    <div class="panel-heading">
        <h3 class="panel-title">Last Transaction Activity</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-5">
                <?= Morris::widget($transactionChart) ?>
            </div>
            <div class="col-sm-7">
                <h4>Last Transaction</h4>
                <?= GridView::widget([
                    'dataProvider' => $transactionDataProvider,
                    'rowOptions' => function ($model) {
                        switch ($model->status) {
                            case (int)Transaction::STATUS_USER_PAY;
                                $class = 'warning';
                                break;
                            default;
                                $class = 'default';
                                break;
                        }
                        return ['class' => $class];
                    },
                    'layout' => '{items}',
                    'columns' => [
                        'user.username',
                        'shipping.cityArea.name',
                        'grand_total:currency',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
