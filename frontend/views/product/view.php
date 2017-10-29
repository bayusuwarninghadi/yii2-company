<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;
use yii\widgets\Breadcrumbs;
use frontend\widgets\carousel\Owl;
use yii\helpers\Inflector;

/* @var string $this */
/* @var $this yii\web\View */
/* @var $model common\models\Pages|common\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = [
	'label' => 'Products',
	'url' => ['/product'],
];
foreach ($model->category as $category) {
	$this->params['breadcrumbs'][] = [
		'label' => $category,
		'url' => ['/product', 'PagesSearch[category]' => $category],
	];
}
?>
    <style>
        .owl-carousel .item {
            margin: 0 10px;
        }
    </style>
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-md-5">
					<?= Breadcrumbs::widget([
						'links' => $this->params['breadcrumbs'],
					]); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="content">
        <div class="container">
            <div class="heading">
                <h3><?= HTMLPurifier::process($model->subtitle) ?></h3>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="row" id="productMain">
                        <div class="col-sm-6">
                            <div id="mainImage">
								<?= UploadHelper::getHtml($model->getImagePath(), 'medium', ['class' => 'img-responsive']) ?>
                            </div>
                            <div class="ribbon">
								<?php if ($model->discount > 0) : ?>
                                    <div class="sale">
                                        <div class="theribbon">SALE <?= $model->discount ?>%</div>
                                    </div>
								<?php endif; ?>
								<?php if ($model->order == 0) : ?>
                                    <div class="new">
                                        <div class="theribbon">NEW</div>
                                    </div>
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="box">
                                <div class="sizes">
                                    <h3>Available sizes</h3>
									<?php foreach ($model->size as $size) : ?>
                                        <a href="#"><?= $size ?></a>
									<?php endforeach; ?>
                                </div>
                                <br>
                                <div class="sizes">
                                    <h3>Available Color</h3>
									<?php foreach ($model->color as $color) : ?>
                                        <a style="background: <?= $color ?>" title="<?= $color ?>"></a>
									<?php endforeach; ?>
                                </div>
                            </div>

							<?php if ($model->pageImages) : ?>
                                <div class="row" id="thumbs">
									<?php
									$images = [];

									$indicator = '';
									foreach ($model->pageImages as $image) {
										$_arr = Json::decode($image->value);
										$content = Html::a(
											Html::img(Yii::$app->components['frontendSiteUrl'] . $_arr['medium'], ['class' => 'img-responsive']),
											Yii::$app->components['frontendSiteUrl'] . $_arr['large'],
											['class' => 'thumb thumbnail']
										);
										$images[] = $content;
									}
									echo Owl::widget([
										'items' => $images,
										'options' => ['class' => 'owl-carousel'],
										'configs' => [
											'items' => 4,
										]
									])
									?>
                                </div>
							<?php endif; ?>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="portfolio-project">
                        <div class="project-more box">
							<?php if ($brand = $model->brand) : ?>
								<?php if ($brand->pageImage) : ?>
									<?= UploadHelper::getHtml('page/' . $brand->id . '/' . $brand->pageImage->id, 'small'); ?>
								<?php endif ?>
                                <h4> <?= $brand->title ?> </h4>
                                <p><?= Html::encode($brand->subtitle) ?></p>
							<?php endif ?>
							<?php foreach ($model->detail as $name => $detail) : ?>
                                <h4><?= Inflector::camel2words($name) ?></h4>
                                <p><?= Html::decode($detail) ?></p>
							<?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box" id="details">
                <blockquote><?= HTMLPurifier::process($model->description) ?></blockquote>
                <i class="fa fa-fw fa-calendar"></i> <?= \Yii::$app->formatter->asDate($model->updated_at) ?>
            </div>

            <div class="box social" id="product-social">
                <h4>Show it to your friends</h4>
                <p>
					<?= Html::a('<i class="fa fa-facebook"></i>', 'http://www.facebook.com/sharer.php?u=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'external facebook', 'data-animate-hover' => 'pulse']) ?>
					<?= Html::a('<i class="fa fa-twitter"></i>', 'http://twitter.com/share?url=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'external twitter', 'data-animate-hover' => 'pulse']) ?>
					<?= Html::a('<i class="fa fa-google-plus"></i>', 'https://plus.google.com/share?url=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'external gplus', 'data-animate-hover' => 'pulse']) ?>
					<?= Html::a('<i class="fa fa-envelope"></i>', 'mailto:?Subject=' . Html::decode($model->title) . '&body=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'email', 'data-animate-hover' => 'pulse']) ?>
                </p>
            </div>

        </div>
    </div>
<?= $this->registerJs("
function productDetailGallery(confDetailSwitch) {
    $('.thumb:first').addClass('active');
    timer = setInterval(autoSwitch, confDetailSwitch);
    
    $('.thumb').click(function (e) {
        switchImage($(this));
        clearInterval(timer);
        timer = setInterval(autoSwitch, confDetailSwitch);
        e.preventDefault();
    }
    );
    $('#mainImage').hover(function () {
	    clearInterval(timer);
    }, function () {
	    timer = setInterval(autoSwitch, confDetailSwitch);
    });
    function autoSwitch() {
        var nextThumb = $('.thumb.active').closest('div').next('div').find('.thumb');
        if (nextThumb.length == 0) {
            nextThumb = $('.thumb:first');
        }
        switchImage(nextThumb);
    }

    function switchImage(thumb) {
        $('.thumb').removeClass('active');
        var bigUrl = thumb.attr('href');
        thumb.addClass('active');
        $('#mainImage img').attr('src', bigUrl);
    }
}
$(document).ready(function(ev){
    productDetailGallery(4000);
})

", \yii\web\View::POS_END) ?>