<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 10/21/17
 * Time: 17:15
 */

namespace frontend\widgets\navigation;

use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\Nav as BaseNav;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\View;


class Nav extends BaseNav
{

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		BootstrapAsset::register($this->getView());
		$this->getView()->registerJs("
			$('.dropdown').on('show.bs.dropdown', function (e) { if ($(window).width() > 750) { $(this).find('.dropdown-menu').first().stop(true, true).slideDown(); } else { $(this).find('.dropdown-menu').first().stop(true, true).show(); }});
	        $('.dropdown').on('hide.bs.dropdown', function (e) { if ($(window).width() > 750) { $(this).find('.dropdown-menu').first().stop(true, true).slideUp(); } else { $(this).find('.dropdown-menu').first().stop(true, true).hide(); } });
		",View::POS_END);
		return $this->renderItems();
	}


	/**
	 * Renders widget items.
	 */
	public function renderItems()
	{
		$items = [];
		foreach ($this->items as $i => $item) {
			if (isset($item['visible']) && !$item['visible']) {
				continue;
			}
			$items[] = $this->renderItem($item);
		}

		return Html::tag('ul', implode("\n", $items), $this->options);
	}

	/**
	 * Renders a widget's item.
	 * @param string|array $item the item to render.
	 * @return string the rendering result.
	 * @throws InvalidConfigException
	 */
	public function renderItem($item)
	{
		if (is_string($item)) {
			return $item;
		}
		if (!isset($item['label'])) {
			throw new InvalidConfigException("The 'label' option is required.");
		}
		$encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
		$label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
		$options = ArrayHelper::getValue($item, 'options', []);
		$items = ArrayHelper::getValue($item, 'items');
		$url = ArrayHelper::getValue($item, 'url', '#');
		$linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

		if (isset($item['active'])) {
			$active = ArrayHelper::remove($item, 'active', false);
		} else {
			$active = $this->isItemActive($item);
		}

		if (empty($items)) {
			$items = '';
		} else {
			$leftContent = ArrayHelper::getValue($item, 'leftContent');

			$linkOptions['data-toggle'] = 'dropdown';
			Html::addCssClass($options, ['widget' => 'dropdown']);
			Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);

			if ($this->dropDownCaret !== '') {
				$label .= ' ' . $this->dropDownCaret;
			}
			if (is_array($items)) {
				if ($this->activateItems) {
					$items = $this->isChildActive($items, $active);
				}
				$items = $this->renderDropdownContent($items, $item, $leftContent);
			}
		}

		if ($this->activateItems && $active) {
			Html::addCssClass($options, 'active');
		}

		if (!empty($leftContent)){
			Html::addCssClass($options, 'use-yamm yamm-fw');
		}

		return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
	}

	/**
	 * @param array $items
	 * @param array $parentItem
	 * @param $leftContent string
	 * @return string
	 */
	protected function renderDropdownContent($items, $parentItem, $leftContent)
	{
		return Dropdown::widget([
			'leftContent' => $leftContent,
			'options' => ArrayHelper::getValue($parentItem, 'dropDownOptions', []),
			'items' => $items,
			'encodeLabels' => $this->encodeLabels,
			'clientOptions' => false,
			'view' => $this->getView(),
		]);
	}

}