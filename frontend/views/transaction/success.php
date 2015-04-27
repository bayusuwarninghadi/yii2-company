<?php
use yii\helpers\HtmlPurifier;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/21/15
 * Time: 02:54
 *
 * @var $cartDataProvider \yii\data\ActiveDataProvider
 * @var $grandTotal integer
 * @var $this \yii\web\View
 * @var $model \common\models\Transaction
 * @var $note \common\models\Article
 */

$this->title = $note->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Success-page">
    <h1><?=$this->title?></h1>
    <p>
        <?= HtmlPurifier::process($note->description) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=Yii::t('app', 'Transaction Detail')?></h3>
        </div>
        <?= $this->render('cartAjax', [
            'dataProvider' => $cartDataProvider,
            'grandTotal' => $grandTotal
        ]) ?>
    </div>
</div>
