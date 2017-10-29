<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 10/21/17
 * Time: 12:55
 */

use frontend\widgets\carousel\Owl;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var array $slider
 * @var $this \yii\web\View
 * @var $indexPage \common\models\Pages
 * @var $indexPartner \common\models\Pages
 * @var $indexNews \common\models\Pages
 * @var $indexProduct \common\models\Pages
 * @var $pills \common\models\Pages[]
 * @var $newsFeeds \common\models\Pages[]
 * @var $contactPopup \common\models\Pages
 * @var $productItems array
 * @var $partnerItems array
 * @var $brandItems array
 * @var $contactForm \frontend\models\ContactForm;
 */

$this->title = Yii::t('app', 'Welcome');
?>


<section class="no-mb">
    <div class="home-carousel"
         style="background-image: url(<?= str_replace('small', 'large', Yii::$app->controller->settings['background_1']) ?>)">
        <div class="dark-mask"></div>
        <div class="container">
			<?php
			echo Owl::widget([
				'items' => $slider,
				'options' => ['class' => 'homepage owl-carousel'],
				'configs' => [
					'navigation' => false,
					'navigationText' => ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
					'slideSpeed' => 2000,
					'paginationSpeed' => 1000,
					'autoPlay' => true,
					'stopOnHover' => true,
					'singleItem' => true,
					'lazyLoad' => false,
					'addClassActive' => true,
				]
			]) ?>

        </div>
    </div>
</section>
<section class="bar background-white">
    <div class="container">
        <div class="heading text-center">
            <h2><?= Yii::$app->controller->settings['site_name'] ?></h2>
        </div>

        <p class="lead text-center">
			<?= HtmlPurifier::process($indexPage->description) ?>
        </p>
        <div class="row">
			<?php foreach ($pills as $pill) : ?>
                <div class="col-md-4">
                    <div class="box-simple">
                        <div class="icon">
                            <i class="fa <?= $pill->subtitle ? $pill->subtitle : 'fa-arrow-down' ?>"></i>
                        </div>
                        <h3><?= $pill->title ?></h3>
                        <p><?= HtmlPurifier::process($pill->description) ?></p>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
    </div>
</section>
<section class="bar background-image-fixed-2 no-mb color-white text-center"
         style="background-image: url(<?= str_replace('small', 'large', Yii::$app->controller->settings['background_2']) ?>)">
    <div class="dark-mask"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="icon icon-lg"><i class="fa fa-file-code-o"></i>
                </div>
                <h3 class="text-uppercase">Do you want to see more?</h3>
                <p class="lead"><?= HtmlPurifier::process($indexProduct->description) ?></p>
                <p class="text-center">
					<?= Html::a('See More', ['/product'], ['class' => 'btn btn-template-transparent-black btn-lg']) ?>
                </p>
            </div>

        </div>
    </div>
</section>
<section class="bar background-white no-mb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading text-center">
                    <h2><?= Yii::t('app', 'Our Products') ?></h2>
                </div>
				<?= Owl::widget(['items' => $productItems]) ?>
            </div>

        </div>
    </div>
</section>
<section class="no-mb">
    <div class="home-carousel white-mask"
         style="background-image: url(<?= str_replace('small', 'large', Yii::$app->controller->settings['background_4']) ?>); padding: 60px 0;">
        <div class="dark-mask"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading text-center">
                        <h2>Our Brand</h2>
                    </div>
					<?php
					echo Owl::widget([
						'items' => $brandItems,
						'options' => ['class' => 'customers owl-carousel'],
						'configs' => [
							'items' => 6,
							'itemsDesktopSmall' => [990, 4],
							'itemsTablet' => [768, 2],
							'itemsMobile' => [480, 1]
						]
					]) ?>

                </div>

            </div>
        </div>
    </div>
</section>

<section class="bar background-pentagon no-mb"
         style="background-image: url(<?= str_replace('small', 'large', Yii::$app->controller->settings['background_3']) ?>)">
    <div class="container">

        <div class="col-md-12">
            <div class="heading text-center">
                <h2><?= Yii::t('app', 'Our Partners') ?></h2>
            </div>

            <p class="lead text-center"><?= HtmlPurifier::process($indexPartner->description) ?></p>

			<?= Owl::widget(['items' => $partnerItems]) ?>
        </div>

    </div>
</section>

<?php
$position = explode(',', Yii::$app->controller->settings['latitude_longitude']);
$lat = $position[0];
$lng = $position[1];
?>
<script>
    function initMap() {
        var location = {lat: <?=$lat?>, lng: <?=$lng?>};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: location
        });
        var infowindow = new google.maps.InfoWindow({
            content: '<?= HtmlPurifier::process($contactPopup->description) ?>'
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            animation: google.maps.Animation.DROP
        });
        marker.addListener('click', function () {
            infowindow.open(map, marker);
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= Yii::$app->controller->settings['google_api_key'] ?>&callback=initMap">
</script>

<section class="bar background-white no-mb">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading text-center">
                    <h2>Contact Us</h2>
                </div>

                <div class="row">
                    <div class="col-sm-7">
                        <div class="form-group">
                            <div id="map" style="width: 100%; height: 402px; border: 1px solid #ccc"></div>
                        </div>
                    </div>
                    <div class="col-sm-5">
						<?php $form = ActiveForm::begin(['id' => 'contact-form', 'action' => ['/site/contact'],]); ?>
						<?php if (\Yii::$app->user->isGuest) : ?>
                            <div class="form-group">
								<?= Html::activeTextInput($contactForm, 'name', ['placeholder' => Yii::t('app', 'Name'), 'class' => 'form-control']) ?>
                            </div>
                            <div class="form-group">
								<?= Html::activeTextInput($contactForm, 'email', ['placeholder' => Yii::t('app', 'Email'), 'class' => 'form-control']) ?>
                            </div>
						<?php endif ?>
                        <div class="form-group">
							<?= Html::activeTextarea($contactForm, 'body', ['placeholder' => Yii::t('app', 'Body'), 'class' => 'form-control', 'rows' => 11]) ?>
                        </div>
                        <div class="form-group">
							<?= Html::submitButton('<i class="fa fa-envelope-o"></i> ' . Yii::t('app', 'Submit'), ['class' => 'btn btn-template-main btn-lg', 'name' => 'contact-button']) ?>
                        </div>
						<?php ActiveForm::end(); ?>
                    </div>
                </div>


            </div>

        </div>
    </div>
</section>
