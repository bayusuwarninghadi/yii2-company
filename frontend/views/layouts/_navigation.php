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
	'Product' => ['/product/index'],
	'News' => ['/news/index'],
	'Contact' => ['/site/contact']
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

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
    'encodeLabels' => false
]);

