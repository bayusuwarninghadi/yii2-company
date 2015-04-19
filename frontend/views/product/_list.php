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
    <?=Html::a('<div class="image" style="background-image:url('.$model->image_url.')"></div>', ['/product/view','id' => $model->id])?>
    <?php if ($model->stock > 0) :?>
    <div class="stock label label-success" data-toggle="popover" title="Stock" data-content="Available">
        <i class="fa fa-truck fa-2x"></i>
    </div>
    <?php else :?>
        <div class="stock label label-danger" data-toggle="popover" title="Stock" data-content="Stock Unavailable">
            <i class="fa fa-truck fa-2x"></i>
        </div>
    <?php endif ?>
    <div class="caption">
        <h4>
            <?=Html::a(Html::decode($model->name), ['/product/view','id' => $model->id])?>
            <small><?=$model->category->name?></small>
        </h4>
        <h4>
            <?php if ($model->discount) :?>
                <?=Yii::$app->formatter->asCurrency($model->price)?>
                <small class="pull-right label label-success"><?=Yii::$app->formatter->asPercent($model->discount/100)?></small>
            <?php else :?>
                <?=Yii::$app->formatter->asCurrency($model->price)?>
            <?php endif ?>
            <div class="clearfix"></div>
        </h4>
        <div class="text-muted"><?=$model->subtitle?></div>
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
            <p class="pull-right"><?=$totalUser?> reviews</p>
            <?php for ($i = 1; $i <= $rating; $i++) :?>
                <span class="glyphicon glyphicon-star"></span>
            <?php endfor ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

