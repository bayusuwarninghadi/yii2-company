<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/23/15
 * Time: 18:44
 */
use frontend\widgets\Alert;

$flash = \Yii::$app->session->getAllFlashes();
$alert_type = [
    'error' => 'alert-danger',
    'success' => 'alert-success',
    'warning' => 'alert-warning',
];
?>
<div class="top-notification">
    <?= Alert::widget() ?>
</div>
