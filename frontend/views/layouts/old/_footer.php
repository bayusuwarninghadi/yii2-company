<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 17:10
 */
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright"><?= \Yii::$app->controller->settings['footer_text'] ?></span>

            </div>
            <div class="col-md-4">
                <ul class="list-inline social-buttons">
                    <li>
						<?= Html::a('<i class="fa fa-facebook"></i>', \Yii::$app->controller->settings['facebook_url']) ?>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-twitter"></i>', \Yii::$app->controller->settings['twitter_url']) ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="list-inline quicklinks">
                    <li><?= Html::a(\Yii::t('app', 'Privacy'), ['/site/privacy']) ?></li>
                    <li><?= Html::a(\Yii::t('app', 'FAQ'), ['/site/faq']) ?></li>
                    <li><?= Html::a(\Yii::t('app', 'About Us'), ['/site/about']) ?></li>
                    <li><?= Html::a(\Yii::t('app', 'Contact Us'), ['/site/contact']) ?></li>
                    <li>
	                    <?=(Yii::$app->language == 'id-ID') ? Html::a('EN', Url::current(['lang' => 'en-US'])) : Html::a('ID', Url::current(['lang' => 'id-ID']));?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>