<?php

use common\modules\UploadHelper;
use yii\bootstrap\Nav;
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

$menuItems = [
    [
        'label' => '<i class="fa fa-truck fa-fw"></i> ' . Yii::t('app', 'Product'),
        'url' => ['/product/index']
    ],
    [
        'label' => '<i class="fa fa-files-o fa-fw"></i> ' . Yii::t('app', 'Article'),
        'items' => [
            [
                'label' => '<i class="fa fa-table fa-fw"></i> ' . Yii::t('app', 'Article'),
                'url' => ['/article/index']
            ],
            '<li class="divider"></li>',
            [
                'label' => '<i class="fa fa-edit fa-fw"></i> ' . Yii::t('app', 'News'),
                'url' => ['/news/index']
            ],
        ]
    ]
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = [
        'label' => '<i class="fa fa-sign-in fa-fw"></i> ' . Yii::t('app', 'Login'),
        'url' => ['/site/login']
    ];
} else {
    $menuItems[] = [
        'label' => '<i class="fa fa-shopping-cart fa-fw"></i> ' . Yii::t('app', 'Shopping Cart'),
        'url' => ['/checkout/cart'],
        'linkOptions' => ['class' => 'visible-xs'],
    ];
    $menuItems[] = [
        'label' => '<i class="fa fa-shopping-cart fa-fw"></i>',
        'linkOptions' => ['class' => 'hidden-xs show-cart'],
        'items' => [
            '<li class="cart-pop" style="padding: 0 10px;">' . $this->render('/layouts/_loading') . '</li>',
            [
                'label' => Yii::t('app', 'See All') . ' <i class="fa fa-angle-right"></i>',
                'linkOptions' => ['class' => 'text-center'],
                'url' => ['/transaction/cart'],
            ],
        ]
    ];

    $menuItems[] = [
        'label' => '<i class="fa fa-user fa-fw"></i>',
        'items' => [
            [
                'label' => '<i class="fa fa-user fa-fw"></i> ' . Yii::t('app', 'Manage Profile'),
                'url' => ['/user/index'],
            ],
            [
                'label' => '<i class="fa fa-heart fa-fw"></i> ' . Yii::t('app', 'Favorites'),
                'url' => ['/user/favorite'],
            ],
            [
                'label' => '<i class="fa fa-columns fa-fw"></i> ' . Yii::t('app', 'Product Compare'),
                'url' => ['/user/comparison'],
            ],
            '<li class="divider"></li>',
            [
                'label' => '<i class="fa fa-check fa-fw"></i> ' . Yii::t('app', 'Confirmation'),
                'url' => ['/user/confirmation'],
            ],
            [
                'label' => '<i class="fa fa-check-circle fa-fw"></i> ' . Yii::t('app', 'View Transaction History'),
                'url' => ['/transaction/index'],
            ],
            '<li class="divider"></li>',
            [
                'label' => '<i class="fa fa-sign-out fa-fw"></i> ' . Yii::t('app', 'Logout'),
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ],
        ]
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => [
        [
            'label' => '<i class="fa fa-flag fa-fw"></i>',
            'items' => [
                [
                    'label' => 'Bahasa',
                    'active' => Yii::$app->language == 'id-ID',
                    'url' => [Yii::$app->getHomeUrl(),'lang' => 'id-ID']
                ],
                [
                    'label' => 'English',
                    'active' => Yii::$app->language == 'en-US',
                    'url' => [Yii::$app->getHomeUrl(),'lang' => 'en-US']
                ],
            ]
        ]
    ],
    'encodeLabels' => false
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
    'encodeLabels' => false
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-form navbar-right'],
    'items' => [
        $this->render('/layouts/_searchNav'),
    ],
    'encodeLabels' => false
]);

NavBar::end();