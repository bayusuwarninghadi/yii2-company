<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <?=Html::a('<i class="fa fa-plus fa-fw"></i> '.$type, ['create'], ['class' => 'btn btn-default pull-right'])?>
    <h1>
        <?= Html::a('<i class="fa fa-bars fa-fw"></i>', '', ['class' => 'toggle-search']) ?>
        <?= Html::encode($this->title) ?>
    </h1>

    <div class="product-wrapper">

        <div class="product-sidebar">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="product-content-wrapper transition">
            <?php
            Pjax::begin();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'title',
                    [
                        'attribute' => 'order',
                        'options' => [
                            'style' => 'width:70px;'
                        ]
                    ],
                    [
                        'attribute' => 'created_at',
                        'options' => [
                            'style' => 'width:110px;'
                        ],
                        'format' => 'date'
                    ],
                    ['class' => 'backend\widget\ActionColumn'],
                ],
            ]);
            Pjax::end();
            ?>

        </div>
    </div>
</div>
