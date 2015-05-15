<?php
use yii\bootstrap\Nav;
use common\models\Category;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/3/15
 * Time: 23:16
 * @var $this \yii\web\View
 */

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right category-navbar'],
    'items' => Category::renderNavItem(),
]);

