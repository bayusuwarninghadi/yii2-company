<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div id="heading-breadcrumbs">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<section class="bar background-white">
    <div class="container">

        <div class="col-md-12">
            <h3 class="section-subheading text-danger">
		        <?= nl2br(Html::encode($message)) ?>
            </h3>
            <p>
		        <?= \Yii::t('app', 'The above error occurred while the Web server was processing your request.') ?>
            </p>

            <p>
		        <?= \Yii::t('app', 'Please contact us if you think this is a server error. Thank you.') ?>
            </p>
        </div>

    </div>
</section>