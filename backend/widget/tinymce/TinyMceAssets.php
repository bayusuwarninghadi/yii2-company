<?php

namespace backend\widget\tinymce;

use yii\web\AssetBundle;

class TinyMceAssets extends AssetBundle
{
	public $sourcePath = '@vendor/tinymce';
	public $js = [
		'tinymce/tinymce.min.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
	];
}
