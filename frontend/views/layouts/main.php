<?php

use yii\helpers\Html;
use frontend\assets\UniversalAsset;

/* @var $this \yii\web\View */
/* @var $content string */

UniversalAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language ?>">
<head>
    <meta charset="<?= \Yii::$app->charset ?>">
    <link rel="icon" type="image/png" href="<?= Yii::$app->controller->settings['site_image'] ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
    <?php $this->head() ?>
</head>
<body data-controller="<?= Yii::$app->controller->id ?>"
      data-action="<?= Yii::$app->controller->action->id ?>">
<?php $this->beginBody() ?>
<div id="all">
    <?= $this->render('/layouts/_navbar') ?>
    <?= $content ?>
    <?= $this->render('/layouts/_footer') ?>
    <?= $this->render('/layouts/_copyright') ?>
</div>
<?php echo $this->render('/layouts/_flash', []) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
