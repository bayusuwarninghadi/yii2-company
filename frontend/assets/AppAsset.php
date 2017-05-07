<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/metisMenu.css',
        'css/agency.min.css',
        'css/site.css',
    ];
    public $js = [
        'js/metisMenu.js',
        'js/masonry.min.js',
        'js/jquery.easing.min.js',
        'js/cbpAnimatedHeader.min.js',
        'js/classie.js',
        'js/agency.js',
        'js/site.js',
    ];
    public $depends = [
        'common\assets\CommonAsset',
    ];
}
