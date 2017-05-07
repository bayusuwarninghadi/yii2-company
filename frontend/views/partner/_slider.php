<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/1/17
 * Time: 18:02
 *
 * @var $models \common\models\Pages[]
 */

use yii\helpers\Html;
use yii\bootstrap\Carousel;

?>
<div class="form-group controls-box text-right">
    <!-- Controls -->
    <div class="controls btn-group">
        <a class="left fa fa-chevron-left btn btn-default" href="#partner-slider" data-slide="prev"></a>
        <a class="right fa fa-chevron-right btn btn-default" href="#partner-slider" data-slide="next"></a>
    </div>
    <div class="clearfix"></div>
</div>
<div class="row">
	<?php
	$items = [];
	foreach ($models as $_item) {
		$items[] =
			Html::beginTag('div', ['class' => 'col-md-3 col-xs-6']) .
			$this->render('/partner/_list', ['model' => $_item]) .
            Html::endTag('div');
	}

	$items = array_chunk($items, 4);

	$partnerSliders = [];

	foreach ($items as $row) {
		$element = Html::beginTag('div', ['class' => 'row']);
		foreach ($row as $item) {
			$element .= $item;
		}
		$element .= Html::endTag('div');
		$partnerSliders[] = $element;
	}

	?>
	<?= Carousel::widget([
		'items' => $partnerSliders,
		'options' => [
			'class' => 'slide',
			'id' => 'partner-slider',
		],
		'showIndicators' => false,
		'controls' => false
	]) ?>
</div>
