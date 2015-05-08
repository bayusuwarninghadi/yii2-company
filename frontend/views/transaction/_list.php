<?php
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/21/15
 * Time: 00:43
 *
 * @var \common\models\Cart $model
 */
?>
<div class="media" title="<?= Html::decode($model->product->subtitle) ?>">
    <?= Html::a(Html::img(Yii::$app->components['frontendSiteUrl'] . $model->product->image_url), ['/product/view', 'id' => $model->product_id], ['class' => 'media-left']) ?>
    <div class="media-body">
        <?= Html::tag('div', Html::decode($model->product->name), ['class' => 'media-heading strong']) ?>
        <div class="media-content">
            <?php if ($model->product->discount) : ?>
                <?= Html::tag('span', '@ ' . Yii::$app->formatter->asCurrency($model->product->price), ['class' => 'line-through']); ?>
                <?= Html::tag('span', Yii::$app->formatter->asPercent($model->product->discount / 100), ['class' => 'label label-success']); ?>
                <?= Html::tag('div', Yii::$app->formatter->asCurrency(round($model->product->price * (100 - ($model->product->discount)) / 100, 0, PHP_ROUND_HALF_UP) * $model->qty)); ?>
            <?php else : ?>
                <?= Html::tag('div', Yii::$app->formatter->asCurrency($model->product->price)); ?>
            <?php endif ?>

        </div>
    </div>
</div>
