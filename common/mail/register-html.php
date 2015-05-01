<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<h2>Hello <?= Html::encode($user->username) ?>,</h2>
Thanks, you've already registered
<br/>
Name : <?= $user->username ?>
<br/>
Email : <?= $user->email ?>