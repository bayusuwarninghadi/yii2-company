<?php

use yii\helpers\Html;
use yii\bootstrap\Carousel;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;

/**
 * @var array $slider
 * @var $this \yii\web\View
 * @var $page \common\models\Pages
 * @var $contents \common\models\Pages[]
 * @var $newsFeeds \common\models\Pages[]
 * @var $articles \common\models\Pages[]
 * @var $partners \common\models\Pages[]
 * @var $model \frontend\models\ContactForm;
 */

$this->title = \Yii::t('app', 'Welcome');

?>

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="#page-top">
	            <?= Yii::$app->controller->settings['site_name'] ?>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li class="">
                    <a class="page-scroll" href="#about">About</a>
                </li>
                <li class="active">
                    <a class="page-scroll" href="#partner">Partner</a>
                </li>
                <li>
                    <a class="page-scroll" href="#news">Lates News</a>
                </li>
                <li>
                    <a class="page-scroll" href="#article">Article</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<div style="margin-top: -20px;">
	<?= Carousel::widget([
		'items' => $slider,
		'options' => [
			'class' => 'index-slider slide',
			'id' => 'index-carousel'
		],
		'controls' => [
			'<span class="glyphicon glyphicon-chevron-left"></span>',
			'<span class="glyphicon glyphicon-chevron-right"></span>',
		]
	]);
	?>

</div>
<section id="about">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading">
				<?= Yii::$app->controller->settings['site_name'] ?>
            </h2>
            <h3 class="section-subheading text-muted">
	            <?= HtmlPurifier::process($page->description) ?>

            </h3>
            <br>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                    <i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">Phase Two Expansion</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam
                    architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">Phase Two Expansion</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam
                    architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                    <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">Phase Two Expansion</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam
                    architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>
        </div>
    </div>
</section>
<section class="bg-light-gray" id="partner">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading">
				<?= Yii::t('app', 'Partners') ?>
            </h2>
            <h3 class="section-subheading text-muted">
				<?= Yii::t('app', 'Kami bermitra dengan regulator dan seluruh ekosistem industri untuk mendorong masa depan keuangan berorientasi teknologi') ?>
            </h3>
        </div>
	    <?= $this->render('/partner/_slider', [
		    'models' => $partners
	    ]) ?>
    </div>
</section>
<?= $this->render('_indexNews', [
	'models' => $newsFeeds
]) ?>
<?= $this->render('_indexArticle', [
	'models' => $articles
]) ?>
<section id="contact">
    <div class="container">
        <h2 class="section-heading text-center">Contact Us</h2>
		<?php $form = ActiveForm::begin(['id' => 'contact-form', 'action' => ['/contact'],]); ?>
        <div class="row">
            <div class="col-sm-6">
				<?php if (\Yii::$app->user->isGuest) : ?>
                    <div class="form-group">
						<?= Html::activeTextInput($model, 'name', ['placeholder' => Yii::t('app', 'Name'), 'class' => 'form-control']) ?>
                    </div>
                    <div class="form-group">
						<?= Html::activeTextInput($model, 'email', ['placeholder' => Yii::t('app', 'Email'), 'class' => 'form-control']) ?>
                    </div>
				<?php endif ?>
                <div class="form-group">
					<?= Html::activeTextInput($model, 'subject', ['placeholder' => Yii::t('app', 'Subject'), 'class' => 'form-control']) ?>
                </div>
                <div class="form-group">
					<?= Html::submitButton(\Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-lg', 'name' => 'contact-button']) ?>
                </div>
            </div>
            <div class="col-sm-6">
				<?= Html::activeTextarea($model, 'body', ['placeholder' => Yii::t('app', 'Body'), 'class' => 'form-control', 'rows' => 11]) ?>
            </div>
        </div>

		<?php ActiveForm::end(); ?>
    </div>
</section>