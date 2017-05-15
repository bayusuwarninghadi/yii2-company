<?php

use yii\bootstrap\NavBar;
use common\modules\UploadHelper;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 17:47
 *
 * @var $this \yii\web\View
 */
?>
    <style>
        #mainNav .navbar-nav > .open > a {
            background: transparent;
            color: #fff;
        }

        #mainNav .dropdown-menu li a {
            color: #fed136;
        }
    </style>
<?php
NavBar::begin([
	'brandLabel' => ($logo = UploadHelper::getHtml('setting/1', 'small', ['class' => 'main-logo'])) ? $logo : Yii::$app->controller->settings['site_name'],
	'brandUrl' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') ?
		'#page-top' :
		\Yii::$app->homeUrl,
	'brandOptions' => [
		'class' => 'page-scroll',
	],
	'options' => [
		'class' => 'navbar navbar-default navbar-fixed-top',
		'id' => 'mainNav'
	],
]);

echo $this->render('/layouts/_language');
echo $this->render('/layouts/_navigation');
//echo $this->render('/layouts/_searchNav');
//echo $this->render('/layouts/_categoryNavbar');
NavBar::end();
