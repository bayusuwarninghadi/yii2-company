<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;
use yii\widgets\Breadcrumbs;
use frontend\widgets\carousel\Owl;

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

        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2><?= Html::decode($model->subtitle) ?></h2>
                </div>
            </div>
        </div>
        <div class="portfolio-project">
            <section>
                <div class="row">

                    <div class="col-sm-8 col-md-9">
						<?php if ($model->pageImages) : ?>
							<?php
							$images = [];

							$indicator = '';
							foreach ($model->pageImages as $image) {
								$_arr = Json::decode($image->value);
								$content = Html::img(Yii::$app->components['frontendSiteUrl'] . $_arr['large'], ['class' => 'img-responsive']);
								$images[] = $content;
							}
							echo Owl::widget([
								'items' => $images,
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
							])
							?>
						<?php endif; ?>
                        <!-- /.project owl-slider -->
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div class="project-more">
							<?php if ($model->pageDetail) : ?>
								<?php foreach (Json::decode($model->pageDetail->value) as $header => $detail) : ?>
                                    <h4><?= $header ?></h4>
                                    <p><?= Html::decode($detail) ?></p>
								<?php endforeach; ?>
							<?php endif ?>
                            <h4>Tags</h4>
                            <?php
                            foreach (Json::decode($model->pageTags->value) as $tag) {
	                            echo Html::tag('span', $tag, ['class' => 'label label-default']) . ' ';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </section>

            <section>

                <div class="heading">
                    <h3>Distributor Descriptions</h3>
                </div>

				<?= HTMLPurifier::process($model->description) ?>
                <div class="box social" id="product-social">
                    <h4>Show it to your friends</h4>
                    <p>
						<?= Html::a('<i class="fa fa-facebook"></i>', 'http://www.facebook.com/sharer.php?u=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'external facebook', 'data-animate-hover' => 'pulse']) ?>
						<?= Html::a('<i class="fa fa-twitter"></i>', 'http://twitter.com/share?url=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'external twitter', 'data-animate-hover' => 'pulse']) ?>
						<?= Html::a('<i class="fa fa-google-plus"></i>', 'https://plus.google.com/share?url=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'external gplus', 'data-animate-hover' => 'pulse']) ?>
						<?= Html::a('<i class="fa fa-envelope"></i>', 'mailto:?Subject=' . Html::decode($model->title) . '&body=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'email', 'data-animate-hover' => 'pulse']) ?>
                    </p>
                </div>
            </section>

        </div>


    </div>
    <!-- /.container -->
</div>
