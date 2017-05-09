<?php
use yii\bootstrap\Nav;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/3/15
 * Time: 23:16
 * @var $this \yii\web\View
 */

$menuItems = [];

$navigation = [
	'About' => ['/site/about'],
	'Partner' => ['/partner/index'],
	'News' => ['/news/index'],
	'Article' => ['/article/index'],
	'Contact' => ['/contact/index']
];
if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'){
	foreach (array_keys($navigation) as $label){
		$menuItems[] = [
			'label' => \Yii::t('app', $label),
			'url' => '#' . strtolower($label),
			'linkOptions' => [
				'class' => 'page-scroll'
			]
		];
	}
} else {
	foreach ($navigation as $label => $url){
		$menuItems[] = [
			'label' => \Yii::t('app', $label),
			'url' => $url
		];
	}
}
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

