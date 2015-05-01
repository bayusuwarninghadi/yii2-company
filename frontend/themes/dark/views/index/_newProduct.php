<?php

use yii\bootstrap\Carousel;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/23/15
 * Time: 00:50
 *
 * @var $products \common\models\Product[]
 */

?>
<section id="new-product">
    <?php
    $items = [];

    foreach ($products as $_item) {
        $items[] =
            Html::beginTag('div', ['class' => 'col-md-3 col-xs-6']) .
            $this->render('/product/_list', ['model' => $_item]) .
            Html::endTag('div');
    }

    // divided carousel/4
    $items = array_chunk($items, 4);

    $carouselItems = [];

    foreach ($items as $row) {
        $element = Html::beginTag('div', ['class' => 'row']);
        foreach ($row as $item) {
            $element .= $item;
        }
        $element .= Html::endTag('div');
        $carouselItems[] = $element;
    }
    echo Carousel::widget([
        'items' => $carouselItems,
        'options' => [
            'id' => 'new-product-slider',
            'class' => 'slide'
        ],
        'showIndicators' => false,
        'controls' => false
    ]);
    ?>
    <div class="controls-box">
        <!-- Controls -->
        <div class="controls pull-right btn-group">
            <a class="left fa fa-chevron-left btn btn-primary" href="#new-product-slider" data-slide="prev"></a>
            <a class="right fa fa-chevron-right btn btn-primary" href="#new-product-slider" data-slide="next"></a>
        </div>
        <h2>
            <?= Yii::t('app', 'New Product') ?>
            <small><?= Html::a('See All', ['/product/index']) ?></small>
        </h2>
        <div class="clearfix"></div>
    </div>
</section>
