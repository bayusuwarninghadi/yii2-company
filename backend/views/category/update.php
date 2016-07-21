<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $modelEnglish common\models\PagesLang */
/* @var $modelIndonesia common\models\PagesLang */


$this->title = 'Update Category: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelEnglish' => $modelEnglish,
        'modelIndonesia' => $modelIndonesia,

    ]) ?>

</div>
