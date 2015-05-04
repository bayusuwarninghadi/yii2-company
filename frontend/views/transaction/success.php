<?php
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

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
 * @var $note \common\models\Pages
 */

$this->title = $note->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Success-page">
    <h1><?=$this->title?></h1>
    <?= HtmlPurifier::process($note->description) ?>
    <?= Html::a('Start Shopping',['/product'],['class' => 'btn btn-success'])?>
 </div>
