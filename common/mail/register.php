<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="heading" style="text-align: center; font-size: 30px; font-weight: lighter; padding: 30px 0; color: #d9534f; ">
    SHOP
</div>
<hr/><br/><br/><br/>

<h2>Hello <?= Html::encode($user->username) ?>,</h2>
Thanks, you've already registered
<br/>
Name : <?= $user->username ?>
<br/>
Email : <?= $user->email ?>

