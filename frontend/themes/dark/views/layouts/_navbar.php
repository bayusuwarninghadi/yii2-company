<?php

use common\modules\UploadHelper;
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
    'brandLabel' => UploadHelper::getHtml('setting/1', 'small', ['class' => 'main-logo'], true),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo $this->render('/layouts/_language');
echo $this->render('/layouts/_navigation');
echo $this->render('/layouts/_searchNav');


NavBar::end();
