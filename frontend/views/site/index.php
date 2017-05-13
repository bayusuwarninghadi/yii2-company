<?php

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

<?= $this->render('_indexPartner', [
	'models' => $partners
]) ?>

<?= $this->render('_indexNews', [
	'models' => $newsFeeds
]) ?>
<?= $this->render('_indexArticle', [
	'models' => $articles
]) ?>
<?= $this->render('_contact', [
	'model' => $contactForm
]) ?>
