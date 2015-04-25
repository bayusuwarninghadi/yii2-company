<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 9/13/14
 * Time: 23:52
 */

namespace common\assets;

use yii\web\AssetBundle;

class CommonAsset extends AssetBundle{
    public $sourcePath = '@common/assets/web';
    public $css = [
        'css/common.css',
    ];
    public $js = [
        'js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesomeAsset',
    ];
}