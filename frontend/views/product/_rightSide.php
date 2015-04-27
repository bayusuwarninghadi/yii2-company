<?php
use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/23/15
 * Time: 00:11
 */

/* @var $cartModel common\models\Cart */
/* @var $model common\models\Product */
/* @var $attributes array */

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php if ($model->discount) : ?>
            <span class="line-through"><?= Yii::$app->formatter->asCurrency($model->price) ?></span>
            <span class="label label-success">
                <?= Yii::$app->formatter->asPercent($model->discount / 100) ?>
            </span>
            <?= Html::tag('b', Yii::$app->formatter->asCurrency(round($model->price * (100 - $model->discount) / 100, 0, PHP_ROUND_HALF_UP)), ['class' => 'pull-right']) ?>
        <?php else : ?>
            <?= Html::tag('b', Yii::$app->formatter->asCurrency($model->price), ['class' => 'pull-right']) ?>
        <?php endif ?>
        <div class="clearfix"></div>
    </div>
    <div class="list-group-item">
        <?php echo UploadHelper::getHtml('brand/' . $model->brand_id) ?>
        <div>
            <?= Html::decode($model->subtitle) ?>
        </div>
        <div>
            <?php if ($model->brand) echo Html::decode($model->subtitle) ?>
        </div>
    </div>
    <div class="list-group-item">
        <?php if ($model->stock) : ?>
            <h5>Stock <span class="label-success label"><?= $model->stock ?></span></h5>
            <?php
            $form = ActiveForm::begin();
            echo $form->field($cartModel, 'qty', [
                'template' => "
                    <div class='input-group input-group-sm' style='max-width: 250px'>
                        <div class='input-group-addon'>".Yii::t('app','Add To Cart')."</div>
                        {input}
                        <div class='input-group-btn'>
                            <button type='submit' class='btn btn-danger'>
                                <i class='fa fa-shopping-cart'></i>
                            </button>
                        </div>
                    </div>
                    \n{error}
                                ",
            ])->input('number', [
                'placeholder' => Yii::t('app','Quantity')
            ]);
            echo Html::activeHiddenInput($cartModel, 'product_id', ['value' => $model->id]);
            $form->end();
            ?>
        <?php else : ?>
            <h5><?=Yii::t('app','Stock Unavailable')?></h5>
        <?php endif ?>
    </div>
    <table class="table">
        <?php foreach ($attributes as $name => $detail) : ?>
            <tr>
                <th><?= Inflector::camel2words($name) ?></th>
                <td><?= Html::decode($detail) ?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <div class="panel-footer">
        <?php if (!Yii::$app->user->isGuest) :?>
            <span class="user-action">
                <a href="<?=Url::to(['/user/toggle-favorite','id' => $model->id])?>" class="btn btn-circle <?= (in_array($model->id, Yii::$app->controller->favorites)) ? 'btn-primary' : 'btn-default'?>" title="<?=Yii::t('app','Toggle User Favorite')?>">
                    <i class="fa fa-heart"></i>
                </a>
                <a href="<?=Url::to(['/user/toggle-comparison','id' => $model->id])?>" class="btn btn-circle <?= (in_array($model->id, Yii::$app->controller->comparison)) ? 'btn-primary' : 'btn-default'?>" title="<?=Yii::t('app','Add/Remove Product From Comparison')?>">
                    <i class="fa fa-columns"></i>
                </a>
            </span>
        <?php endif ?>
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-facebook fa-fw fa-lg"></i>', 'http://www.facebook.com/sharer.php?u=' . Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-primary btn-circle']) ?>
            <?= Html::a('<i class="fa fa-twitter fa-fw fa-lg"></i>', 'http://twitter.com/share?url=' . Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-info btn-circle']) ?>
            <?= Html::a('<i class="fa fa-google-plus fa-fw fa-lg"></i>', 'https://plus.google.com/share?url=' . Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-danger btn-circle']) ?>
            <?= Html::a('<i class="fa fa-envelope fa-fw fa-lg"></i>', 'mailto:?Subject='.Html::decode($model->name).'&body=' . Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-warning btn-circle']) ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>