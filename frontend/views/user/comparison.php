<?php
use yii\bootstrap\Carousel;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/22/15
 * Time: 00:06
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */
$this->title = Yii::t('app', "Product Comparison");
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?=$this->title?></h1>
<div class="controls-box page-header">
    <!-- Controls -->
    <div class="pull-right">
        <?=Yii::t('app', 'Total Item Compare:')?> <strong><?=$dataProvider->getCount()?></strong>
        <div class="controls btn-group">
            <a class="left fa fa-chevron-left btn btn-primary" href="#comparison-slider" data-slide="prev"></a>
            <a class="right fa fa-chevron-right btn btn-primary" href="#comparison-slider" data-slide="next"></a>
        </div>
    </div>
    <strong>
        <?=Yii::t('app', 'Click on products bellow to compare')?>
    </strong>

    <div class="clearfix"></div>
</div>
<?php
$items = [];
foreach ($dataProvider->getModels() as $_item) {
    $items[] =
        Html::beginTag('div', ['class' => 'col-xs-6']) .
        $this->render('/user/_productComparison', ['model' => $_item]) .
        Html::endTag('div');
}

// divided carousel/4
$items = array_chunk($items, 2);

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
        'id' => 'comparison-slider',
        'class' => 'slide'
    ],
    'showIndicators' => false,
    'controls' => false
]); ?>
