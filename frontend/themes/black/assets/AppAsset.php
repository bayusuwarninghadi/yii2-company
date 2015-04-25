<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\themes\black\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/themes/black/web';
    public $css = [
        'css/black.css',
    ];
    public $js = [
        'js/black.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        'yii\bootstrap\BootstrapThemeAsset',
    ];
}
