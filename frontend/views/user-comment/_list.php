<?php
use yii\helpers\HtmlPurifier;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 14:24
 * @var \common\models\UserComment $model
 */
?>

<div class="row">
    <div class="col-sm-3">
        <div><?= $model->user->username ?></div>
        <div>
            <small><i class="fa fa-calendar"></i> <?= Yii::$app->formatter->asDate($model->created_at) ?></small>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="text-primary">
            <?php for ($i = 1; $i <= $model->rating; $i++) :?>
                <i class="fa fa-star"></i>
            <?php endfor ?>
            <?=$model->title?>
        </div>
        <p>
            <?=HtmlPurifier::process($model->comment)?>
        </p>
    </div>
</div>
