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
class UniversalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'universal/css/animate.min.css',
        'universal/css/style.default.min.css',
        'universal/css/overide.css',
    ];
    public $js = [
        'universal/js/jquery.parallax-1.1.3.min.js',
    ];
    public $depends = [
        'common\assets\CommonAsset',
    ];
}
