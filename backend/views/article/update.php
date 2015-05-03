<?php

use yii\helpers\Html;

/* @var string $type */
/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $articleEnglish common\models\ArticleLang */
/* @var $articleIndonesia common\models\ArticleLang */


$this->title = 'Update ' . $type . ': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'articleEnglish' => $articleEnglish,
        'articleIndonesia' => $articleIndonesia,
    ]) ?>

</div>
