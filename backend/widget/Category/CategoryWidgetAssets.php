<?php

namespace backend\widget\category;

use yii\web\AssetBundle;

/**
 * Class CategoryWidgetAssets
 * @package backend\widget\category
 */
class CategoryWidgetAssets extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@backend/widget/category/assets';
    /**
     * @var array
     */
    public $css = [
        'style.css',
    ];
}
