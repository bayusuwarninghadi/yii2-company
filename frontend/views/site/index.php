<?php

use yii\helpers\Html;
use yii\bootstrap\Carousel;

/**
 * @var array $slider
 * @var $this \yii\web\View
 * @var $indexPage \common\models\Pages
 * @var $pills \common\models\Pages[]
 * @var $newsFeeds \common\models\Pages[]
 * @var $articles \common\models\Pages[]
 * @var $partners \common\models\Pages[]
 * @var $contactForm \frontend\models\ContactForm;
 */

$this->title = \Yii::t('app', 'Welcome');

?>
<style>
    section#contact{
        background-image: url('/images/map-image.png');
    }
</style>
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
<?= $this->render('_indexPills', [
	'pills' => $pills,
	'indexPage' => $indexPage,
]) ?>

<section class="bg-light-gray" id="partner">
    <div class="container-fluid">
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
        <div class="text-center">
	        <?=Html::a('See More', ['/partner'], ['class' => 'btn btn-primary btn-lg'])?>
        </div>
    </div>
</section>

<?= $this->render('_indexNews', [
	'models' => $newsFeeds
]) ?>
<?= $this->render('_indexArticle', [
	'models' => $articles
]) ?>
<?= $this->render('_contact', [
	'model' => $contactForm
]) ?>
