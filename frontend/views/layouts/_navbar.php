<?php

use yii\bootstrap\NavBar;
use frontend\widgets\navigation\Nav;
use yii\helpers\Html;
use common\models\Pages;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/3/15
 * Time: 23:16
 * @var $this \yii\web\View
 */

?>
<header>
    <div class="navbar-affixed-top" data-spy="affix" data-offset-top="200">

		<?php
		NavBar::begin([
			'brandLabel' => Html::img(Yii::$app->controller->settings['site_image']),
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'class' => 'navbar navbar-default yamm',
				'id' => 'navbar',
				'data-spy' => 'affix',
				'data-offset-top' => 200
			],
		]);
		$menuCategory = [
			'label' => Yii::t('app', 'Product'),
			'leftContent' => Html::img('/universal/img/template-easy-customize.png', ['class' => 'img-responsive hidden-xs']),
		];

		$categories = [];
		foreach (Pages::getAvailableTags(Pages::PAGE_ATTRIBUTE_CATEGORY) as $category){
			$categories[] = ['label' => $category, 'url' => ['/product', 'PagesSearch[category]' => $category]];
		}

        if (isset($categories)){
			$menuCategory['items'] = $categories;
        }
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav navbar-right'],
			'items' => [
				['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
				$menuCategory,
				['label' => Yii::t('app', 'Partner'), 'url' => ['/partner/about']],
				['label' => Yii::t('app', 'News'), 'url' => ['/news/about']],
				['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
			],
			'encodeLabels' => false
		]);

		NavBar::end();
		?>
    </div>
</header>
