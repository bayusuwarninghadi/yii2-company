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

    <?=Html::a(Html::img('http://placehold.it/320x150'), ['view','id' => $model->id])?>
    <div class="caption">
        <h5><a href="#"><?=Html::decode($model->name)?></a></h5>
        <h4>
            <?php if ($model->discount) :?>
                <?=Yii::$app->formatter->asCurrency($model->price)?>
                <small class="label label-success"><?=Yii::$app->formatter->asPercent($model->discount/100)?></small>
            <?php else :?>
                <?=Yii::$app->formatter->asCurrency($model->price)?>
            <?php endif ?>
        </h4>
        <div>Stock: <?=$model->stock?></div>
        <div>Category: <?=$model->category->name?></div>
    </div>
    <div class="ratings">
        <p class="pull-right">15 reviews</p>
        <p>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
        </p>
    </div>
</div>

