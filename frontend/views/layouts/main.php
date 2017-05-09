<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language ?>">
<head>
    <meta charset="<?= \Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet'
          type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
	<?php $this->head() ?>
</head>
<body data-controller="<?=Yii::$app->controller->id?>"
      data-action="<?=Yii::$app->controller->action->id?>"
      class="index" id="page-top">
<?php $this->beginBody() ?>
<?= $this->render('/layouts/_navbar') ?>
<?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') : ?>
	<?= $content ?>
<?php else : ?>
    <div class="header-breaker"></div>
    <?= $content ?>
<?php endif ?>
<?= $this->render('/layouts/_footer') ?>
<?php echo $this->render('/layouts/_flash', []) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
