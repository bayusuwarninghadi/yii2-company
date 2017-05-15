<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = \Yii::t('app', 'Contact Us');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #map {
        height: 300px;
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
            animation: google.maps.Animation.DROP,
        });
        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= Yii::$app->controller->settings['google_api_key'] ?>&callback=initMap">
</script>
<div id="map"></div>
<?= $this->render('_contact', [
	'model' => $model
]) ?>
