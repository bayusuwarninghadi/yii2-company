<?php
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 22:51
 *
 * @var \common\models\Product $model
 */
?>
<div class="thumbnail">

    <?php // Html::a(Html::img('http://placehold.it/320x150'), ['view','id' => $model->id])?>
    <div class="caption">
        <h4>
            <?=Html::a(Html::decode($model->name), ['view','id' => $model->id])?>
            <small><?=$model->category->name?></small>
        </h4>
        <div class="text-muted"><?=$model->subtitle?></div>
        <h4>
            <?php if ($model->discount) :?>
                <?=Yii::$app->formatter->asCurrency($model->price)?>
                <small class="label label-success"><?=Yii::$app->formatter->asPercent($model->discount/100)?></small>
            <?php else :?>
                <?=Yii::$app->formatter->asCurrency($model->price)?>
            <?php endif ?>
        </h4>
        <div><i class="fa fa-truck fa-fw"></i> <?=$model->price ? 'Stock Available' : 'Stock Not Available'?></div>
    </div>
    <div class="ratings">
        <?php
        $totalRating = 0;
        $totalUser = 0;
        $rating = 0;
        if ($model->rating) {
            $arr = explode('/', $model->rating);
            $totalRating = intval($arr[0]);
            $totalUser = intval($arr[1]);
            $rating = $totalUser ? round($totalRating / $totalUser, 0) : $rating;
        }

        ?>
        <div>
            <p class="pull-right"><?=$rating?> reviews</p>
            <p>
                <?php for ($i = 1; $i <= $rating; $i++) :?>
                    <span class="glyphicon glyphicon-star"></span>
                <?php endfor ?>
            </p>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

