<?php

/**
 * Morris class file.
 */

namespace backend\widget\chart;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

/**
 * Class Morris
 * Morris::widget([
 * 'type' => 'Bar',
 *       'options' => [
 *          'data' => $data,
 *          'xkey' => 'period',
 *          'ykeys' => ['total'],
 *          'labels' => ['total'],
 *          'pointSize' => 2,
 *          'hideHover' => 'auto',
 *          'resize' => true
 *       ],
 * ])
 * @package backend\widget\chart
 */
class Morris extends Widget
{
    /**
     * @var string
     */
    public $type = 'Area';
    /**
     * @var array
     */
    public $options = [];
    /**
     * @var array
     */
    public $containerOptions = [];
    /**
     * @var bool
     */
    public $callback = false;

    /**
     * Renders the widget.
     */
    public function run()
    {
        // determine the ID of the container element
        if (isset($this->containerOptions['id'])) {
            $this->id = $this->containerOptions['id'];
        } else {
            $this->id = $this->containerOptions['id'] = $this->getId();
        }

        // render the container element
        echo Html::tag('div', '', $this->containerOptions);

        // check if options parameter is a json string
        if (is_string($this->options)) {
            $this->options = Json::decode($this->options);
        }

        // merge options with default values
        $defaultOptions = ['element' => $this->id];
        $this->options = ArrayHelper::merge($defaultOptions, $this->options);

        $this->registerAssets();

        parent::run();
    }

    /**
     * Registers required assets and the executing code block with the view
     */
    protected function registerAssets()
    {
        // register the necessary assets
        MorrisAsset::register($this->view)->withScripts();

        // prepare and register JavaScript code block
        $jsOptions = Json::encode($this->options);
        $js = "Morris.{$this->type}($jsOptions);";
        $key = __CLASS__ . '#' . $this->id;
        if (is_string($this->callback)) {
            $callbackScript = "function {$this->callback}(data) {{$js}}";
            $this->view->registerJs($callbackScript, View::POS_READY, $key);
        } else {
            $this->view->registerJs($js, View::POS_LOAD, $key);
        }
    }
}
