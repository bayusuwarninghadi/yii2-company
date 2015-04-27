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
        &copy; <?=Yii::$app->controller->settings['site_name']?> <?= date('Y') ?>
        <p>
            <small>
                <?=Html::a(Yii::t('app','Privacy'),['/site/privacy'])?>
                <?=Html::a(Yii::t('app','FAQ'),['/site/faq'])?>
                <?=Html::a(Yii::t('app','About Us'),['/site/about'])?>
                <?=Html::a(Yii::t('app','Contact Us'),['/site/contact'])?>
            </small>
        </p>
    </div>
</section>
