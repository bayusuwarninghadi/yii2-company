<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $gallery \common\models\ProductAttribute[] */

$this->title = 'Update Product: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($gallery) :?>
        <div class="well">
            <h3>GALLERY</h3>
            <div class="row product-gallery text-center">
                <?php foreach ($gallery as $image) : ?>
                    <?php $availableImages = Json::decode($image->value) ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"
                         data-url="<?=$availableImages['medium']?>"
                         data-product="<?=$model->id?>"
                         data-id="<?=$image->id?>">
                        <a href=""
                           class="gallery-container <?=($availableImages['medium'] == $model->image_url) ? 'active' : ''?>"
                           title="Set As Product Cover">
                            <div class="gallery"
                                 style="background-image: url(<?= UploadHelper::getImageUrl('product/' . $model->id . '/' . $image->id,'medium') ?>)">
                            </div>
                        </a>
                        <a href="" class="btn btn-danger btn-sm" data-dismiss="gallery-grid-container" aria-hidden="true"><i class="fa fa-trash-o"></i> Delete</a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php $this->registerJsFile('/js/product.js', ['depends' => JqueryAsset::className()]); ?>

