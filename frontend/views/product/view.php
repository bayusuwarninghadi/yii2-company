<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset;
use yii\bootstrap\Carousel;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $gallery common\models\ProductAttribute[] */
/* @var $cartModel common\models\Cart */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
    <h1 class="page-header"><?= Html::decode($model->name) ?> <small><?= $model->category->name ?></small></h1>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <?php
                $images = [];
                foreach ($gallery as $image){
                    $_arr = Json::decode($image->value);
                    $images[] = Html::img($_arr['large']);
                }
                if (!$images) $images[] = Html::img($model->image_url);
                echo Carousel::widget([
                    'items' => $images,
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left"></span>',
                        '<span class="glyphicon glyphicon-chevron-right"></span>',
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-8">
                <div class="form-group"><?= Html::decode($model->subtitle) ?></div>
                <div class="row">
                    <div class="col-sm-6">
                        <?php if ($model->discount) : ?>
                            <h5>
                                <span class="line-through"><?= Yii::$app->formatter->asCurrency($model->price) ?></span>
                                <span class="label label-success">
                                    <?= Yii::$app->formatter->asPercent($model->discount / 100) ?>
                                </span>
                            </h5>
                            <?= Html::tag('h1',Yii::$app->formatter->asCurrency($model->price * (100 - $model->discount) / 100)) ?>
                        <?php else : ?>
                            <?= Html::tag('h1',Yii::$app->formatter->asCurrency($model->price)) ?>
                        <?php endif ?>
                    </div>
                    <div class="col-sm-6">
                        <?php if ($model->stock) :?>
                            <h5>Stock <span class="label-success label"><?= $model->stock ?></span></h5>
                            <?php
                            echo Html::tag('h5', 'Add To Cart');
                            $form = ActiveForm::begin();
                            echo $form->field($cartModel, 'qty', [
                                'template' => "
                                    <div class='input-group input-group-sm' style='width: 140px'>
                                        {input}
                                        <div class='input-group-btn'>
                                            <button type='submit' class='btn btn-primary'>
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
                        <div class="form-group">
                            <h5>Share with your friend</h5>
                            <?=Html::a('<i class="fa fa-facebook fa-fw fa-lg"></i>','#')?>
                            <?=Html::a('<i class="fa fa-twitter fa-fw fa-lg"></i>','#')?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?php
        $arr = explode('/', $model->rating);

        echo Tabs::widget([
            'items' => [
                [
                    'label' => 'Description',
                    'content' => HtmlPurifier::process($model->description),
                ],
                [
                    'label' => $arr[1] . ' Reviews',
                    'content' => Html::tag('div', $this->render('/layouts/_loading'), [
                        'class' => 'comment-container',
                        'data-id' => $model->id
                    ]),
                ],
            ],

        ]) ?>
    </div>
</div>
<?php $this->registerJsFile('/js/product.js', ['depends' => JqueryAsset::className()]); ?>
