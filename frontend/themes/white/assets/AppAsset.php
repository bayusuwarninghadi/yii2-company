<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\themes\white\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/themes/white/web';
    public $css = [
        'css/white.css',
    ];
    public $js = [
        'js/white.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        'yii\bootstrap\BootstrapThemeAsset',
    ];
}
