<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Product Search');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'All Product'),
    'url' => ['/product']
];

if ($searchModel->cat_id) {
    /** @var \common\models\Category|\creocoder\nestedsets\NestedSetsBehavior $category */
    /** @var \common\models\Category|\creocoder\nestedsets\NestedSetsBehavior $parent */
    $category = $searchModel->category;
    foreach ($category->parents()->all() as $parent) {
        if (!$parent->isRoot()) {
            $this->params['breadcrumbs'][] = [
                'label' => $parent->name,
                'url' => ['/product', 'ProductSearch[cat_id]' => $parent->id]
            ];
        }
    }
    $this->params['breadcrumbs'][] = $category->name;
}
?>
<div class="category-index">
    <div class="row">
        <?php Pjax::begin(); ?>
        <div class="col-md-3 col-sm-4">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-md-9 col-sm-8">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list',
                'layout' => '
                    <div class="form-group">
                        <div class="pull-right" style="margin-top: -5px">
                            <div class="dropdown">
                                <button class="btn btn-default btn-sm dropdown-toggle dropdown-menu-left" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                    ' . Yii::t('app', 'View') . '
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a class="toggle-view list"><i class="fa fa-list"></i> ' . Yii::t('app', 'List') . '</a></li>
                                    <li><a class="toggle-view grid"><i class="fa fa-th-large"></i> ' . Yii::t('app', 'Grid') . '</a></li>
                                </ul>
                            </div>
                        </div>
                        {summary}
                        <div class="clearfix"></div>
                    </div>
                    <div class="row product-container">{items}</div>
                    {pager}',
                'itemOptions' => [
                    'class' => 'col-sm-6 col-lg-4 col-md-4 col-xs-6 product-list'
                ]
            ]);
            ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>

