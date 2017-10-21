<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 10/21/17
 * Time: 13:37
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<footer id="footer">
	<div class="container">
		<div class="col-md-3 col-sm-6">
			<h4>About us</h4>

			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>

			<hr class="hidden-md hidden-lg hidden-sm">

		</div>
		<!-- /.col-md-3 -->

		<div class="col-md-3 col-sm-6">

			<h4>Blog</h4>
            <ul>
                <li><?= Html::a(\Yii::t('app', 'Privacy'), ['/site/privacy']) ?></li>
                <li><?= Html::a(\Yii::t('app', 'FAQ'), ['/site/faq']) ?></li>
                <li><?= Html::a(\Yii::t('app', 'About Us'), ['/site/about']) ?></li>
                <li><?= Html::a(\Yii::t('app', 'Contact Us'), ['/site/contact']) ?></li>
                <li>
                    <?=(Yii::$app->language == 'id-ID') ? Html::a('EN', Url::current(['lang' => 'en-US'])) : Html::a('ID', Url::current(['lang' => 'id-ID']));?>
                </li>
            </ul>
			<hr class="hidden-md hidden-lg">

		</div>
		<!-- /.col-md-3 -->

		<div class="col-md-3 col-sm-6">

			<h4>Contact</h4>

			<p><strong>Universal Ltd.</strong>
				<br>13/25 New Avenue
				<br>Newtown upon River
				<br>45Y 73J
				<br>England
				<br>
				<strong>Great Britain</strong>
			</p>

			<hr class="hidden-md hidden-lg hidden-sm">

		</div>
		<!-- /.col-md-3 -->



		<div class="col-md-3 col-sm-6">

			<h4>Social</h4>
            <a href="<?=Yii::$app->controller->settings['facebook_url']?>">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x text-primary"></i>
                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                </span>
            </a>
            <a href="<?=Yii::$app->controller->settings['twitter_url']?>">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square fa-stack-2x text-info"></i>
                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                </span>
            </a>

			<div class="photostream">
				<div>
				</div>
                <div>
                </div>
			</div>

		</div>
		<!-- /.col-md-3 -->
	</div>
	<!-- /.container -->
</footer>
