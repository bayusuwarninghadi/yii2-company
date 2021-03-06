<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?php if (\Yii::$app->user->isGuest) : ?>
        <?= $content ?>
    <?php else : ?>    
        <div id="wrapper">
            <?= $this->render('_navigation'); ?>
            <div id="page-wrapper">
                <?= Breadcrumbs::widget([
                    'encodeLabels' => false,
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'homeLink' => [
                        'label' => '<i class="fa fa-home fa-fw"></i> Home',
                        'url' => \Yii::$app->homeUrl
                    ]
                ]) ?>
                <div class="main-container">
                    <?= $content ?>
                </div>
            </div>
        </div>
        <div class="footer"><?=Html::a('bay_oz', 'http://twitter.com/bay_oz')?> <?=Date('Y')?></div>
    <?php endif ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
