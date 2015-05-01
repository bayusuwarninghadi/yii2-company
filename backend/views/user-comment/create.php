<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserComment */

$this->title = Yii::t('app', 'Create User Comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
