<?php
use yii\bootstrap\Carousel;
use yii\helpers\Inflector;
use yii\helpers\Html;
use yii\helpers\Url;

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
<h1><?=$this->title?></h1>
<div class="row">
    <div class="col-sm-3 col-lg-4">
        <div class="thumbnail">
            <?=Html::img(Url::to(['/setting/theme-preview', 'theme' => $model->value]))?>
            <div class="text-center">Currently <small><?=Inflector::camel2words($model->value)?></small></div>
        </div>
    </div>
    <div class="col-sm-9 col-lg-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Carousel::widget([
                    'items' => $carouselTheme,
                    'options' => [
                        'id' => 'theme-slider',
                        'class' => 'slide'
                    ],
                    'showIndicators' => false,
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left"></span>',
                        '<span class="glyphicon glyphicon-chevron-right"></span>',
                    ]
                ])?>
            </div>
        </div>
    </div>
</div>