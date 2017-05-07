<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<section class="bg-light-gray">
    <div class="container text-center">
        <h2 class="section-heading text-danger">
			<?= Html::encode($this->title) ?>
        </h2>
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
</section>