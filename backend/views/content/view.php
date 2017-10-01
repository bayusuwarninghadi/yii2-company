<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;
use common\modules\UploadHelper;

/* @var string $this */
/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var string $type */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-green">
        <div class="panel-heading"><i class="fa fa-list fa-fw"></i> Detail</div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'title',
                [
                    'label' => 'image',
                    'value' => UploadHelper::getHtml('content/' . $model->id, 'small'),
                    'format' => 'html'
                ],
                'category.title',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
        <div class="panel-body">
            <?= HtmlPurifier::process($model->description) ?>
        </div>
    </div>

</div>
