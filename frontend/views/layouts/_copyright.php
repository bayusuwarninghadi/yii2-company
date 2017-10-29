<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 10/21/17
 * Time: 13:37
 */
?>
<div id="copyright">
	<div class="container">
		<div class="col-md-12">
			2017 <?=Yii::$app->controller->settings['site_name']?>
            <span class="pull-right">
                <?=Yii::t('app','Language')?>
                <?=(Yii::$app->language == 'id-ID') ? Html::a('EN', Url::current(['lang' => 'en-US'])) : Html::a('ID', Url::current(['lang' => 'id-ID']));?>
            </span>
		</div>
	</div>
</div>

