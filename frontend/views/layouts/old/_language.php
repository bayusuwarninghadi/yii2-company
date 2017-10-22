<?php
use yii\bootstrap\Nav;
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/3/15
 * Time: 23:08
 *
 * @var $this \yii\web\View
 */

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => [
        [
            'label' => '<i class="fa fa-flag fa-fw"></i>',
            'items' => [
                [
                    'label' => 'Indonesia',
                    'active' => \Yii::$app->language == 'id-ID',
                    'url' => Url::current(['lang' => 'id-ID'])
                ],
                [
                    'label' => 'English',
                    'active' => \Yii::$app->language == 'en-US',
                    'url' => Url::current(['lang' => 'en-US'])
                ],
            ]
        ]
    ],
    'encodeLabels' => false
]);