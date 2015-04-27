<?php
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 22:51
 *
 * @var \common\models\Product $model
 */
?>
<div class="thumbnail transition">
    <?=Html::a('<div class="image" style="background-image:url('.$model->image_url.')"></div>', ['/product/view','id' => $model->id],['class' => 'product-image'])?>
    <?php if ($model->stock > 0) :?>
        <div class="stock label label-success" data-toggle="popover" data-content="<?=Yii::t('yii','Stock Available')?>">
            <i class="fa fa-truck fa-2x"></i>
        </div>
    <?php else :?>
        <div class="stock label label-danger" data-toggle="popover" data-content="<?=Yii::t('yii','Stock Unavailable')?>">
            <i class="fa fa-truck fa-2x"></i>
        </div>
    <?php endif ?>
    <?php if (!Yii::$app->user->isGuest) :?>
        <div class="btn-group user-action">
            <a href="<?=Url::to(['/user/toggle-favorite','id' => $model->id])?>" class="btn btn-circle <?= (in_array($model->id, Yii::$app->controller->favorites)) ? 'btn-primary' : 'btn-default'?>" title="<?=Yii::t('yii','Toggle User Favorite')?>">
                <i class="fa fa-heart"></i>
            </a>
            <a href="<?=Url::to(['/user/toggle-comparison','id' => $model->id])?>" class="btn btn-circle <?= (in_array($model->id, Yii::$app->controller->comparison)) ? 'btn-primary' : 'btn-default'?>" title="<?=Yii::t('yii','Add/Remove To Product Compare')?>">
                <i class="fa fa-columns"></i>
            </a>
        </div>
    <?php endif ?>
    <div class="product-detail">
        <div class="caption">
            <h4>
                <?=Html::a(Html::decode($model->name), ['/product/view','id' => $model->id])?>
                <small><?=$model->category->name?></small>
            </h4>
            <h4>
                <?php if ($model->discount) :?>
                    <span class="line-through"><?=Yii::$app->formatter->asCurrency($model->price)?></span>
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
</div>

