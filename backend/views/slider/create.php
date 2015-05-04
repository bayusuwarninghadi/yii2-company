<?php

use yii\helpers\Html;

/* @var string $type */
/* @var $this yii\web\View */
/* @var $model common\models\Pages */

$this->title = 'Create ' . $type;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
