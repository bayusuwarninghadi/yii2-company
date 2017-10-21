<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 10/21/17
 * Time: 13:00
 */

namespace frontend\widgets\carousel;


use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class Owl extends Widget
{
	public $items = [];
	public $options = ['class' => 'owl-carousel testimonials same-height-row'];
	public $configs = [
            'items'=> 4,
            'itemsDesktopSmall' => [990, 3],
            'itemsTablet' =>  [768, 2],
            'itemsMobile'=> [480, 1]
    ];

	public function run()
	{
		parent::run();
		OwlAsset::register($this->getView());
		if (isset($this->options['id'])) {
			$id = $this->options['id'];
		} else {
			$this->options['id'] = $id = $this->getId();
		}

		echo Html::beginTag('div', $this->options);
		foreach ($this->items as $item) {
			echo Html::tag('div', $item, ['class' => 'item']);
		}
		echo Html::endTag('div');
		$this->getView()->registerJs("$('#$id').owlCarousel(" . Json::encode($this->configs) . ");");
	}
}