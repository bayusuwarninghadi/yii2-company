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
 * @var $page \common\models\Pages
 * @var $products \common\models\Product[]
 * @var $brands \common\models\Brand[]
 */

$this->title = Yii::t('app', 'Welcome');

?>
<?= Carousel::widget([
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
<div class="container main-container" data-spy="scroll" data-target="#indexScrollspy"
     style="padding-top: 0; padding-bottom: 0;">
    <?= $this->render('/index/_newProduct', [
        'products' => $products
    ]) ?>
    <section id="about-page" class="bg-white row">
        <div class="col-sm-4 col-md-3 hidden-xs">
            <?= $this->render('/index/_brand', [
                'brands' => $brands
            ]) ?>
        </div>
        <div class="col-sm-8 col-md-9">
            <?= HtmlPurifier::process($page->description) ?>
        </div>
    </section>
</div>