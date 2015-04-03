<?php
/**
 * Tinymce v4.0.21
 * Homepage: http://www.tinymce.com/
 * Examples: http://www.tinymce.com/tryit/basic.php
 * Options: http://www.tinymce.com/wiki.php/Configuration
 */

namespace backend\widget\tinymce;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Class TinyMce
 * @package common\component\module\tinymce
 */
class TinyMce extends InputWidget
{
    /**
     * @var string
     */
    public $id = '';
    /**
     * @var string
     */
    public $content = '';
    /**
     * @var array
     */
    public $configs = [];
    /**
     * [
     *      'plugin_name' => 'plugin_url'
     * ]
     * @var array
     */
    public $addPlugin = [];

    /**
	 * Initializes the widget.
	 */
	public function init() {
		TinyMceAssets::register($this->view);
	}

	/**
	 * Renders the widget.
	 */
	public function run() {
        $this->options['id'] = empty($this->id) ? 'tinymce' . rand(0, 1000) : $this->id;
        $this->configs['selector'] = 'textarea#' . $this->options['id'];

        foreach ($this->addPlugin as $name => $url) {
            $this->getView()->registerJs('tinymce.PluginManager.load("'.$name.'","'. $url .'");');
            $this->configs['plugins'] = $this->configs['plugins'].' -'.$name;
            $this->configs['toolbar'] = $this->configs['toolbar'].' | '.$name;
        }

        $this->getView()->registerJs('tinymce.init('. Json::encode($this->configs) .');');
        echo Html::activeTextarea($this->model, $this->attribute, $this->options);
	}
}
