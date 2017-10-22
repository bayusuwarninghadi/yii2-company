<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 10/21/17
 * Time: 17:23
 */

namespace frontend\widgets\navigation;

use yii\bootstrap\Dropdown as BaseDropdown;
use yii\bootstrap\BootstrapPluginAsset;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class Dropdown extends BaseDropdown
{
	public $leftContent = null;

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		BootstrapPluginAsset::register($this->getView());
		$this->registerClientEvents();
		return $this->renderItems($this->items, $this->options);
	}

	/**
	 * Renders menu items.
	 * @param array $items the menu items to be rendered
	 * @param array $options the container HTML attributes
	 * @return string the rendering result.
	 * @throws InvalidConfigException if the label option is not specified in one of the items.
	 */
	protected function renderItems($items, $options = [])
	{
		$lines = [];
		foreach ($items as $item) {
			if (isset($item['visible']) && !$item['visible']) {
				continue;
			}
			if (is_string($item)) {
				$lines[] = $item;
				continue;
			}
			if (!array_key_exists('label', $item)) {
				throw new InvalidConfigException("The 'label' option is required.");
			}
			$encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
			$label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
			$itemOptions = ArrayHelper::getValue($item, 'options', []);
			$linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
			$linkOptions['tabindex'] = '-1';
			$url = array_key_exists('url', $item) ? $item['url'] : null;
			if (empty($item['items'])) {
				if ($url === null) {
					$content = $label;
					Html::addCssClass($itemOptions, ['widget' => 'dropdown-header']);
				} else {
					$content = Html::a($label, $url, $linkOptions);
				}
			} else {
				$submenuOptions = $this->submenuOptions;
				if (isset($item['submenuOptions'])) {
					$submenuOptions = array_merge($submenuOptions, $item['submenuOptions']);
				}
				$content = Html::a($label, $url === null ? '#' : $url, $linkOptions)
					. $this->renderItems($item['items'], $submenuOptions);
				Html::addCssClass($itemOptions, ['widget' => 'dropdown-submenu']);
			}

			$lines[] = Html::tag('li', $content, $itemOptions);
		}

		$innerContent = implode("\n", $lines);

		if ($this->leftContent != null){
			$left_content = Html::tag('div', $this->leftContent, ['class' => 'col-sm-6']);
			$right_content = Html::tag('div', Html::tag('ul', $innerContent), ['class' => 'col-sm-6']);

			$content = Html::tag('row', $left_content . $right_content, ['class' => 'row']);

			$innerContent = Html::tag('li', Html::tag('div', $content, ['class' => 'yamm-content']));
		}

		return Html::tag('ul', $innerContent, $options);
	}

}