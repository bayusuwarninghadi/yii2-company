<?php

/**
 * MorrisAsset class file.
 *
 * @author Milo Schuman <miloschuman@gmail.com>
 * @link https://github.com/miloschuman/yii2-highcharts/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 4.0.4
 */

namespace backend\widget\chart;

use yii\web\AssetBundle;

/**
 * Asset bundle for morris widget.
 */
class MorrisAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@backend/widget/chart/asset';
    /**
     * @var array
     */
    public $depends = ['yii\web\JqueryAsset'];

    /**
     * Registers additional JavaScript files required by the widget.
     * @return $this
     */
    public function withScripts()
    {
        $this->css[] = 'morris.css';
        $this->js[] = 'raphael.js';
        $this->js[] = 'morris.js';

        return $this;
    }
}
