<?php

use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 17:04
 *
 * @var array $slider
 * @var $this \yii\web\View
 * @var $page \common\models\Article
 * @var $products \common\models\Product
 */

$this->title = 'Shop';

echo Carousel::widget([
    'items' => $slider,
    'options' => [
        'id' => 'index-slider'
    ],
    'controls' => [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ]
]);
?>
<section class="bg-primary">
    <div class="container">
        <?= HtmlPurifier::process($page->description) ?>
    </div>
</section>
<section>
    <div class="container">
        <h2 id="new-product">
            New Product
            <small><?= Html::a('See All', ['/product']) ?></small>
        </h2>
        <div class="row">
            <?php foreach ($products as $product) : ?>
                <div class="col-sm-6 col-md-3">
                    <?= $this->render('/product/_list', [
                        'model' => $product
                    ]) ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
