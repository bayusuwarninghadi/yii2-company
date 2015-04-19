<?php
use yii\bootstrap\Carousel;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/19/15
 * Time: 15:25
 *
 * @var array $images
 */

echo Carousel::widget([
    'items' => $images,
    'options' => [
        'id' => Yii::$app->request->isAjax ? 'large-gallery' : 'small-gallery',
    ],
    'controls' => [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ]
]);