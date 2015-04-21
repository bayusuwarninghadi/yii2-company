<?php

use yii\bootstrap\NavBar;
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
    'brandLabel' => '<i class="fa fa-home fa-fw"></i>',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$menuItems = [
    [
        'label' => 'Our Product',
        'url' => ['/product/index']
    ],
    [
        'label' => 'Press',
        'items' => [
            ['label' => '<i class="fa fa-table fa-fw"></i> Article', 'url' => ['/article/index']],
            '<li class="divider"></li>',
            ['label' => '<i class="fa fa-edit fa-fw"></i> News', 'url' => ['/news/index']],
        ]
    ]
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => '<i class="fa fa-sign-in fa-fw"></i>', 'url' => ['/site/login']];
} else {
    $menuItems[] = [
        'label' => 'Shopping Cart',
        'url' => ['/checkout/cart'],
        'linkOptions' => [
            'class' => 'visible-xs'
        ],
    ];
    $menuItems[] = [
        'label' => '<i class="fa fa-shopping-cart fa-fw"></i>',
        'linkOptions' => [
            'class' => 'show-cart visible-sm visible-md visible-lg'
        ],
        'items' => [
            '<li class="cart-pop">'.$this->render('_loading').'</li>',
            [
                'label' => 'See All <i class="fa fa-angle-right"></i>',
                'linkOptions' => [
                    'class' => 'text-center'
                ],
                'url' => ['/transaction/cart'],
            ],
        ]
    ];

    $menuItems[] = [
        'label' => '<i class="fa fa-user fa-fw"></i>',
        'items' => [
            [
                'label' => '<i class="fa fa-user fa-fw"></i> Profile',
                'url' => ['/user/index'],
            ],
            [
                'label' => '<i class="fa fa-heart fa-fw"></i> Favorites',
                'url' => ['/user/favorite', 'id' => Yii::$app->user->getId()],
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
