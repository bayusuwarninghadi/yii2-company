<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\themes\dark\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->controller->settings['site_name']) ?> | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?=$this->render('_navigation')?>
    <div class="container main-container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>
<?=$this->render('/layouts/_footer')?>
<?php echo $this->render('/layouts/_flash', []) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
