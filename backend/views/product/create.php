<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $modelEnglish common\models\ProductLang */
/* @var $modelIndonesia common\models\ProductLang */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelEnglish' => $modelEnglish,
        'modelIndonesia' => $modelIndonesia,
    ]) ?>

</div>
