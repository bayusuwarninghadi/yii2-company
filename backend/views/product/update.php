<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $gallery \common\models\ProductAttribute[] */
/* @var $modelEnglish common\models\ProductLang */
/* @var $modelIndonesia common\models\ProductLang */

$this->title = 'Update Product: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'All Product'),
    'url' => ['/product']
];
/** @var \common\models\Category|\creocoder\nestedsets\NestedSetsBehavior $currentCategory */
/** @var \common\models\Category|\creocoder\nestedsets\NestedSetsBehavior $parent */
$currentCategory = $model->category;
foreach ($currentCategory->parents()->all() as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = [
            'label' => $parent->name,
            'url' => ['/product', 'ProductSearch[cat_id]' => $parent->id]
        ];
    }
}
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['/product', 'ProductSearch[cat_id]' => $model->cat_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (isset($model->productImages)) : ?>
        <div class="well">
            <h3>GALLERY</h3>

            <div class="row product-gallery text-center">
                <?php foreach ($model->productImages as $image) : ?>
                    <?php $availableImages = Json::decode($image->value) ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"
                         data-url="<?= $availableImages['medium'] ?>"
                         data-product="<?= $model->id ?>"
                         data-id="<?= $image->id ?>">
                        <a href=""
                           class="gallery-container <?= ($availableImages['medium'] == $model->image_url) ? 'active' : '' ?>"
                           title="Set As Product Cover">
                            <div class="gallery"
                                 style="background-image: url(<?= UploadHelper::getImageUrl('product/' . $model->id . '/' . $image->id, 'medium') ?>)">
                            </div>
                        </a>
                        <a href="" class="btn btn-danger btn-sm" data-dismiss="gallery-grid-container"
                           aria-hidden="true">
                            <i class="fa fa-trash-o"></i> Delete
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
        'modelEnglish' => $modelEnglish,
        'modelIndonesia' => $modelIndonesia,
    ]) ?>

</div>

