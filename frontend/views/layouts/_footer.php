<?php
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 17:10
 */
?>
<section class="footer">
    <div class="container text-center">
        <div class="social">
            <?=Html::a('<i class="fa fa-facebook"></i>',Yii::$app->controller->settings['facebook_url'],['class'=>'btn btn-lg btn-circle btn-primary'])?>
            <?=Html::a('<i class="fa fa-twitter"></i>',Yii::$app->controller->settings['twitter_url'],['class'=>'btn btn-lg btn-circle btn-info'])?>
        </div>
        &copy; My Company <?= date('Y') ?>
        <p>
            <small>
                <?=Html::a('Privacy',['/site/privacy'])?>
                <?=Html::a('FAQ',['/site/faq'])?>
                <?=Html::a('About',['/site/about'])?>
                <?=Html::a('Contact',['/site/contact'])?>
            </small>
        </p>
    </div>
</section>
