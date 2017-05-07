<?php

use yii\bootstrap\NavBar;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 17:47
 *
 * @var $this \yii\web\View
 */

NavBar::begin([
    'brandLabel' => Yii::$app->controller->settings['site_name'],
    'brandUrl' => \Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-default navbar-fixed-top',
        'id' => 'mainNav'
    ],
]);

echo $this->render('/layouts/_language');
echo $this->render('/layouts/_navigation');
//echo $this->render('/layouts/_searchNav');
echo $this->render('/layouts/_categoryNavbar');

NavBar::end();
