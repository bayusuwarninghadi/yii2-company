<?php
/**
 * Created by PhpStorm.
 * User: bayu
 * Date: 4/28/17
 * Time: 11:00 AM
 *
 * @var $model \frontend\models\ContactForm
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<style>
    #map {
        height: 480px;
        width: 100%;
    }
</style>
<?php
$position = explode(',', Yii::$app->controller->settings['latitude_longitude']);
$lat = $position[0];
$lng = $position[1];
?>
<script>
    function initMap() {
        var location = {lat: <?=$lat?>, lng: <?=$lng?>};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: location
        });
        var infowindow = new google.maps.InfoWindow({
            content: 'LOKASI KAMI'
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            animation: google.maps.Animation.DROP
        });
        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= Yii::$app->controller->settings['google_api_key'] ?>&callback=initMap">
</script>

<section id="contact">
    <div class="container">
        <h2 class="section-heading text-center">Contact Us</h2>
        <div></div>
        <div class="row">
            <div class="col-sm-7">
                <div class="form-group">
                    <div id="map"></div>
                </div>
            </div>
            <div class="col-sm-5">
                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'action' => ['/contact'],]); ?>
                <?php if (\Yii::$app->user->isGuest) : ?>
                    <div class="form-group">
                        <?= Html::activeTextInput($model, 'name', ['placeholder' => Yii::t('app', 'Name'), 'class' => 'form-control']) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::activeTextInput($model, 'email', ['placeholder' => Yii::t('app', 'Email'), 'class' => 'form-control']) ?>
                    </div>
                <?php endif ?>
                <div class="form-group">
                    <?= Html::activeTextarea($model, 'body', ['placeholder' => Yii::t('app', 'Body'), 'class' => 'form-control', 'rows' => 11]) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-lg', 'name' => 'contact-button']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</section>

