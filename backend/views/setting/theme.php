<?php
use yii\bootstrap\Carousel;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/25/15
 * Time: 16:51
 *
 * @var $carouselTheme array
 * @var $model \common\models\Setting
 * @var $this \yii\web\View
 */
$this->title = 'Select Theme';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .carousel-caption {
        background: rgba(0,0,0,0.8);
    }
</style>
<div class="row">
    <div class="col-sm-8">
        <h1>
            <div class="controls pull-right btn-group">
                <a class="left fa fa-chevron-left btn btn-default" href="#theme-slider" data-slide="prev"></a>
                <a class="right fa fa-chevron-right btn btn-default" href="#theme-slider" data-slide="next"></a>
            </div>
            <?=$this->title?>
            <div class="clearfix"></div>
        </h1>
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Carousel::widget([
                    'items' => $carouselTheme,
                    'options' => [
                        'id' => 'theme-slider',
                        'class' => 'slide'
                    ],
                    'showIndicators' => false,
                    'controls' => false
                ])?>
            </div>
        </div>
    </div>
</div>