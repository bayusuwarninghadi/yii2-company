<?php

use backend\widget\NavBar;
use yii\bootstrap\Nav;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 17:47
 *
 * @var $this \yii\web\View
 */

NavBar::begin([
    'brandLabel' => 'My Company',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$menuItems = [
    ['label' => '<i class="fa fa-list fa-fw"></i> Product', 'url' => ['/product/index']],
    ['label' => '<i class="fa fa-table fa-fw"></i> Article', 'url' => ['/article/index']],
    ['label' => '<i class="fa fa-edit fa-fw"></i> News', 'url' => ['/news/index']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = [
        'label' => '<i class="fa fa-shopping-cart fa-fw"></i>',
        'url' => ['/checkout/cart']
    ];

    $menuItems[] = [
        'label' => '<i class="fa fa-user fa-fw"></i>',
        'items' => [
            [
                'label' => '<i class="fa fa-user fa-fw"></i> Profile',
                'url' => ['/site/profile'],
            ],
            '<li class="divider"></li>',
            [
                'label' => '<i class="fa fa-sign-out fa-fw"></i>  Logout',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ],
        ]
    ]
    ;
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
    'encodeLabels' => false
]);
NavBar::end();
