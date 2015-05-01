<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Hello <?= Html::encode($user->username) ?>,
Thanks, you've already registered

Name : <?= $user->username ?>
Email : <?= $user->email ?>

