<?php

use yii\bootstrap\Carousel;
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
 * @var $products \common\models\Product[]
 * @var $brands \common\models\Brand[]
 */

$this->title = 'Welcome';

echo Carousel::widget([
    'items' => $slider,
    'options' => [
        'id' => 'index-slider',
    ],
    'controls' => [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ]
]);
?>
<section class="bg-white" id="about-page">
    <div class="container">
        <div class="col-sm-4 col-md-3 hidden-xs">
            <?=$this->render('_brand',[
                'brands' => $brands
            ])?>
        </div>
        <div class="col-sm-8 col-md-9">
            <?= HtmlPurifier::process($page->description) ?>
        </div>
    </div>
</section>
<?=$this->render('_newProduct',[
    'products' => $products
])?>
