<?php
use yii\widgets\ActiveForm;
use yii\helpers\Inflector;
use yii\helpers\Html;

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
<div class="panel panel-primary">
    <div class="panel-heading">
        <?php if ($model->discount) : ?>
            <span class="line-through"><?= Yii::$app->formatter->asCurrency($model->price) ?></span>
            <span class="label label-success">
                                <?= Yii::$app->formatter->asPercent($model->discount / 100) ?>
                            </span>
            <?= Html::tag('b',Yii::$app->formatter->asCurrency($model->price * (100 - $model->discount) / 100),['class' => 'pull-right']) ?>
        <?php else : ?>
            <?= Html::tag('b',Yii::$app->formatter->asCurrency($model->price),['class' => 'pull-right']) ?>
        <?php endif ?>
        <div class="clearfix"></div>
    </div>
    <div class="list-group-item">
        <div>
            <?= Html::decode($model->subtitle) ?>
        </div>
        <div>
            <?php if ($model->brand) echo Html::decode($model->subtitle) ?>
        </div>
    </div>
    <div class="list-group-item">
        <?php if ($model->stock) :?>
            <h5>Stock <span class="label-success label"><?= $model->stock ?></span></h5>
            <?php
            $form = ActiveForm::begin();
            echo $form->field($cartModel, 'qty', [
                'template' => "
                    <div class='input-group input-group-sm' style='width: 200px'>
                        <div class='input-group-addon'>Add To Cart</div>
                        {input}
                        <div class='input-group-btn'>
                            <button type='submit' class='btn btn-danger'>
                                <i class='fa fa-shopping-cart'></i>
                            </button>
                        </div>
                    </div>
                    \n{error}
                                ",
            ])->input('number',[
                'placeholder' => 'Quantity'
            ]);
            echo Html::activeHiddenInput($cartModel,'product_id',['value' => $model->id]);
            $form->end();
            ?>
        <?php else :?>
            <h5>Stock <span class="label-danger label">Unavailable</span></h5>
        <?php endif ?>
    </div>
    <table class="table">
        <?php foreach ($attributes as $name => $detail) :?>
            <tr>
                <th><?=Inflector::camel2words($name)?></th>
                <td><?=Html::decode($detail)?></td>
            </tr>
        <?php endforeach ?>
    </table>
    <div class="panel-footer text-right">
        <?=Html::a('<i class="fa fa-facebook fa-fw fa-lg"></i>','#',['class' => 'btn btn-primary btn-circle'])?>
        <?=Html::a('<i class="fa fa-twitter fa-fw fa-lg"></i>','#',['class' => 'btn btn-info btn-circle'])?>
        <?=Html::a('<i class="fa fa-google-plus fa-fw fa-lg"></i>','#',['class' => 'btn btn-danger btn-circle'])?>
    </div>
</div>