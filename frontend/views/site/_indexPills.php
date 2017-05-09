<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/9/17
 * Time: 11:16
 */


use yii\helpers\HtmlPurifier;
/**
 * @var $indexPage \common\models\Pages
 * @var $pills \common\models\Pages[]
*/
?>

<section id="about">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading">
				<?= Yii::$app->controller->settings['site_name'] ?>
			</h2>
			<h3 class="section-subheading text-muted">
				<?= HtmlPurifier::process($indexPage->description) ?>

			</h3>
			<br>
		</div>
		<div class="row text-center">
			<?php foreach ($pills as $pill) :?>
			<div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa <?=$pill->subtitle ? $pill->subtitle : 'fa-arrow-down'?> fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading"><?=$pill->title?></h4>
                <p class="text-muted">
					<?= HtmlPurifier::process($pill->description) ?>
				</p>
			</div>
			<?php endforeach;?>
		</div>
	</div>
</section>
