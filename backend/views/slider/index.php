<?php

use backend\widget\GridView;
use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <?=Html::a('<i class="fa fa-plus fa-fw"></i> Slider', ['create'], ['class' => 'btn btn-default pull-right'])?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Image',
                'value' => function ($model) {
                    /** @var $model \common\models\Pages */
	                return ($model->pageImage ? Html::tag('div', UploadHelper::getHtml('page/' . $model->id . '/' . $model->pageImage->id, 'small')) : "");
                },
                'format' => 'html'
            ],
            'title',
            [
                'attribute' => 'subtitle',
                'label' => 'URL'
            ],
            [
                'attribute' => 'order',
                'options' => [
                    'style' => 'width:70px;'
                ]
            ],
            [
                'class' => 'backend\widget\ActionColumn',
                'template' => '<div class="text-center"><div class="btn-group" role="group">{update} {delete}</div></div>'
            ],
        ],
    ]);
    Pjax::end();
    ?>

</div>
