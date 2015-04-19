<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var array $images */
/* @var $cartModel common\models\Cart */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
    <h1 class="page-header"><?= Html::decode($model->name) ?> <small><?= $model->category->name ?></small></h1>
    <div class="form-group">
        <div class="row">
            <div class="col-md-5 product-slider">
                <div class="panel">
                    <?=$this->render('_gallery',['images'=>$images])?>
                	<div class="text-center visible-md visible-lg panel-body">
                        <a class="btn btn-primary toggle-preview"><i class="fa fa-arrows-alt"></i> Preview</a>
                	</div>
                </div>

            </div>
            <div class="col-md-7">
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
                    </div>
                	<div class="list-group-item">
                        <?= Html::decode($model->subtitle) ?>
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
                    <div class="panel-footer">
                        Share with your friend
                        <?=Html::a('<i class="fa fa-facebook fa-fw fa-lg"></i>','#')?>
                        <?=Html::a('<i class="fa fa-twitter fa-fw fa-lg"></i>','#')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <h3>Related Product</h3>
    <div class="well related-product" data-id="<?=$model->id?>">
        <div class="row">
            <?=$this->render('/layouts/_loading')?>
        </div>
    </div>
</div>
<div class="modal fade" id="gallery-modal" data-id="<?=Html::decode($model->id)?>">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?=Html::decode($model->name)?></h4>
			</div>
			<div class="modal-body">
                <?=$this->render('/layouts/_loading')?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->registerJsFile('/js/product.js', ['depends' => JqueryAsset::className()]); ?>
