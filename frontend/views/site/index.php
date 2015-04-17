<?php

use yii\bootstrap\Carousel;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 17:04
 */

echo Carousel::widget([

    'items' => [
        Html::img('http://placehold.it/1200x400'),
        ['content' => Html::img('http://placehold.it/1200x400')],
        [
            'content' => Html::img('http://placehold.it/1200x400'),
            'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
        ],
    ]
]);