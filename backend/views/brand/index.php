<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;
use common\modules\UploadHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <?= Html::a('<i class="fa fa-plus fa-fw"></i> Brand', ['create'], ['class' => 'btn btn-default pull-right']) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Image',
                'value' => function ($data) {
                    return UploadHelper::getHtml('brand/' . $data->id, 'medium', ['style' => 'height:50px;'], true);
                },
                'format' => 'html'
            ],
            'brand',
            [
                'class' => 'backend\widget\ActionColumn',
                'template' => '<div class="text-center"><div class="btn-group" role="group">{update} {delete}</div></div>'
            ],
        ],
    ]);
    Pjax::end();
    ?>

</div>
