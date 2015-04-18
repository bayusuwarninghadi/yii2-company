<?php
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 17:10
 */
?>
<footer class="footer">
    <div class="container">
        <p class="pull-left">
            &copy; My Company <?= date('Y') ?>
        </p>
        <p class="pull-right">
            <?=Html::a('About',['/site/about'])?>
            <?=Html::a('Contact',['/site/contact'])?>
        </p>
    </div>
</footer>
