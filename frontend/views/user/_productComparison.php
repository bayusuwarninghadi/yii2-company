<?php
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\HtmlPurifier;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/26/15
 * Time: 23:24
 * @var \common\models\Product $model
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?=Html::encode($model->name)?></h3>
    </div>
    <?=Html::a(Html::img($model->image_url), ['/product/view','id' => $model->id])?>
    <table class="table">
        <tr>
            <th><?=Yii::t('app', 'Price')?></th>
            <td><?=Yii::$app->formatter->asCurrency($model->price)?></td>
        </tr>
        <tr>
            <th><?=Yii::t('app', 'Discount')?></th>
            <td><?=Yii::$app->formatter->asPercent($model->discount / 100)?></td>
        </tr>
        <tr>
            <th><?=Yii::t('app', 'Grand Total')?></th>
            <td><?=Yii::$app->formatter->asCurrency(round($model->price * (100 - $model->discount) / 100, 0, PHP_ROUND_HALF_UP))?></td>
        </tr>
        <?php foreach ($model->getProductAttributeDetailValue() as $name => $detail) : ?>
            <tr>
                <th><?= Inflector::camel2words($name) ?></th>
                <td><?= Html::decode($detail) ?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <div class="panel-body">
        <?=HtmlPurifier::process($model->description)?>
    </div>
</div>