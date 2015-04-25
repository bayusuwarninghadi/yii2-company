<?php

use yii\helpers\Html;
use backend\widget\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-8">
            <?php
            Pjax::begin();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'title',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}'
                    ],
                ],
            ]);
            Pjax::end();
            ?>
        </div>
    </div>
</div>
