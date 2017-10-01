<?php

use yii\helpers\Html;

/* @var string $type */
/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $modelEnglish common\models\PagesLang */
/* @var $modelIndonesia common\models\PagesLang */


$this->title = 'Create ' . $type;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
        'modelEnglish' => $modelEnglish,
        'modelIndonesia' => $modelIndonesia,
    ]) ?>

</div>
