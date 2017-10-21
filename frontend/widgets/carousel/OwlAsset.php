<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 9/13/17
 * Time: 15:18
 */

namespace frontend\widgets\carousel;


use yii\web\AssetBundle;

class OwlAsset extends AssetBundle
{
	public $sourcePath = '@frontend/widgets/carousel/assets';
	public $js = [
		'owl.carousel.min.js',
	];
	public $css = [
		'owl.carousel.min.css',
		'owl.theme.min.css',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
	];
}