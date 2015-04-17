<?php
use yii\helpers\Html;

/* @var $category common\models\Category */
?>
<div class="btn-group btn-group-sm hide">
    <?= Html::a('<i class="fa fa-users fa-fw"></i>', ['create-category', 'prepend' => $category->id], ['class' => 'btn btn-primary', 'title' => 'Add Child'])?>
    <?= Html::a('<i class="fa fa-user fa-fw"></i>', ['create-category', 'after' => $category->id], ['class' => 'btn btn-success', 'title' => 'Insert After This Category'])?>
    <?= Html::a('<i class="fa fa-pencil fa-fw"></i>', ['update-category', 'id' => $category->id], ['class' => 'btn btn-warning', 'title' => 'Edit This Category'])?>
    <?= Html::a('<i class="fa fa-trash fa-fw"></i>', ['delete-category', 'id' => $category->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
        'title' => 'Delete This Category'
    ]) ?>
</div>
