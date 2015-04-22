<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\web\JqueryAsset;


/* @var $this yii\web\View */
/* @var array $images */
/* @var $cartModel common\models\Cart */
/* @var $model common\models\Product */
/* @var $attributes array */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
    <h1 class="page-header"><?= Html::decode($model->name) ?> <small><?= $model->category->name ?></small></h1>
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <div class="panel product-slider">
                        <?=$this->render('_gallery',['images'=>$images])?>
                        <div class="text-center visible-md visible-lg panel-body">
                            <a class="btn btn-primary toggle-preview"><i class="fa fa-arrows-alt"></i> Preview</a>
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
                </div>
            </div>
            <div class="col-md-5">
                <?=$this->render('_leftSide',[
                    'model' => $model,
                    'attributes' => $attributes,
                    'cartModel' => $cartModel
                ])?>
            </div>
        </div>
    <h3>Related Product</h3>
    <div class="related-product" data-id="<?=$model->id?>">
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
