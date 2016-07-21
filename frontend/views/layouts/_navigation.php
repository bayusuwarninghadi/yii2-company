<?php
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/3/15
 * Time: 23:16
 * @var $this \yii\web\View
 */

$menuItems = [
    [
        'label' => '<i class="fa fa-files-o fa-fw"></i>',
        'items' => [
            [
                'label' => '<i class="fa fa-table fa-fw"></i> ' . \Yii::t('app', 'Article'),
                'url' => ['/article/index']
            ],
            '<li class="divider"></li>',
            [
                'label' => '<i class="fa fa-edit fa-fw"></i> ' . \Yii::t('app', 'News'),
                'url' => ['/news/index']
            ],
        ]
    ]
];
if (\Yii::$app->user->isGuest) {
    $menuItems[] = [
        'label' => '<i class="fa fa-sign-in fa-fw"></i> ' . \Yii::t('app', 'Login'),
        'url' => ['/site/login']
    ];
} else {
    $menuItems[] = [
        'label' => '<i class="fa fa-shopping-cart fa-fw"></i> ' . \Yii::t('app', 'Shopping Cart'),
        'url' => ['/checkout/cart'],
        'linkOptions' => ['class' => 'visible-xs'],
    ];
    $menuItems[] = [
        'label' => '<i class="fa fa-shopping-cart fa-fw"></i>',
        'linkOptions' => ['class' => 'hidden-xs show-cart'],
        'items' => [
            '<li class="cart-pop" style="padding: 0 10px;">' . $this->render('/layouts/_loading') . '</li>',
            '<li class="container-fluid">
                <div class="row">
                    <div class="col-xs-6">
                    ' . Html::a(\Yii::t('app', 'See All'), ['/transaction/cart'], ['class' => 'btn btn-xs btn-success']) . '
                    </div>
                    <div class="col-xs-6 text-right">
                    ' . Html::a('<i class="fa fa-cart-arrow-down fa-fw"></i>' . \Yii::t('app', 'Checkout'), ['/transaction/checkout'], ['class' => 'btn btn-xs btn-warning']) . '
                    </div>
                </div>
            </li>',
        ]
    ];

    $menuItems[] = [
        'label' => '<i class="fa fa-user fa-fw"></i>',
        'items' => [
            [
                'label' => '<i class="fa fa-user fa-fw"></i> ' . \Yii::t('app', 'Manage Profile'),
                'url' => ['/user/index'],
            ],
            [
                'label' => '<i class="fa fa-heart fa-fw"></i> ' . \Yii::t('app', 'Favorites'),
                'url' => ['/user/favorite'],
            ],
            [
                'label' => '<i class="fa fa-columns fa-fw"></i> ' . \Yii::t('app', 'Product Compare'),
                'url' => ['/user/comparison'],
            ],
            '<li class="divider"></li>',
            [
                'label' => '<i class="fa fa-check fa-fw"></i> ' . \Yii::t('app', 'Confirmation'),
                'url' => ['/user/confirmation'],
            ],
            [
                'label' => '<i class="fa fa-check-circle fa-fw"></i> ' . \Yii::t('app', 'View Transaction History'),
                'url' => ['/transaction/index'],
            ],
            '<li class="divider"></li>',
            [
                'label' => '<i class="fa fa-sign-out fa-fw"></i> ' . \Yii::t('app', 'Logout'),
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ],
        ]
    ];
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
    'encodeLabels' => false
]);

