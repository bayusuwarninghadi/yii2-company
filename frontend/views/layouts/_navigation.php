<?php
use yii\bootstrap\Nav;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/3/15
 * Time: 23:16
 * @var $this \yii\web\View
 */

$menuItems = [
	[
		'label' => \Yii::t('app', 'Article'),
		'url' => ['/article/index']
	],
	[
		'label' => \Yii::t('app', 'Partner'),
		'url' => ['/partner/index']
	],
	[
		'label' => \Yii::t('app', 'News'),
		'url' => ['/news/index']
	],
];
if (\Yii::$app->user->isGuest) {
    $menuItems[] = [
        'label' => \Yii::t('app', 'Login'),
        'url' => ['/site/login']
    ];
} else {

    $menuItems[] = [
        'label' => Yii::$app->user->identity['username'],
        'items' => [
            [
                'label' => \Yii::t('app', 'Manage Profile'),
                'url' => ['/user/index'],
            ],
            '<li class="divider"></li>',
            [
                'label' => \Yii::t('app', 'Logout'),
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

