<?php

use yii\bootstrap\Carousel;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;
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
<h2 id="new-product" class="page-header">New Product <small><?=Html::a('See All', ['/product'])?></small></h2>
<div class="row">
    <?php foreach ($products as $product) :?>
        <div class="col-sm-6 col-md-3">
            <?=$this->render('/product/_list',[
                'model' => $product
            ])?>
        </div>
    <?php endforeach ?>
</div>
<?php

echo HtmlPurifier::process($page->description);
