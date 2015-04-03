<?php

/* @var $this yii\web\View */

use yii\bootstrap\BootstrapAsset;
use yii\web\JqueryAsset;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;


$this->registerCssFile(Yii::$app->getHomeUrl() . 'css/animate.css', ['depends' => BootstrapAsset::className()]);
$this->registerCssFile(Yii::$app->getHomeUrl() . 'css/slick.css', ['depends' => BootstrapAsset::className()]);
$this->registerCssFile(Yii::$app->getHomeUrl() . 'js/rs-plugin/css/settings.css', ['depends' => BootstrapAsset::className()]);
$this->registerCssFile(Yii::$app->getHomeUrl() . 'css/berry.css', ['depends' => BootstrapAsset::className()]);
$this->registerJsFile(Yii::$app->getHomeUrl() . 'js/modernizr.custom.32033.js');
?>

    <?=$this->render('_header')?>
    <div class="wrapper">
        <?=$this->render('_overview')?>
        <?=$this->render('_feature')?>
        <?=$this->render('_review')?>
        <?=$this->render('_screen')?>
        <?=$this->render('_app')?>
        <footer>
            <div class="container">
                <a href="#" class="scrollpoint sp-effect3">
                    <img src="img/berry/logo.png" alt="" class="logo">
                </a>

                <div class="social">
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-twitter fa-lg"></i></a>
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-google-plus fa-lg"></i></a>
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-facebook fa-lg"></i></a>
                </div>
                <div class="rights">
                    <p> Copyright &copy; <?= date('Y') ?> &nbsp; <span class="label label-warning">APPTRON</span><span class="label label-danger">.io</span> </p>

                </div>
            </div>
        </footer>

    </div>
<?php
$this->registerJsFile(Yii::$app->getHomeUrl() . 'js/slick.min.js', ['depends' => JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getHomeUrl() . 'js/placeholdem.min.js', ['depends' => JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getHomeUrl() . 'js/rs-plugin/js/jquery.themepunch.plugins.min.js', ['depends' => JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getHomeUrl() . 'js/rs-plugin/js/jquery.themepunch.revolution.min.js', ['depends' => JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getHomeUrl() . 'js/waypoints.min.js', ['depends' => JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getHomeUrl() . 'js/index.js', ['depends' => JqueryAsset::className()]);