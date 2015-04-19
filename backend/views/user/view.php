<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
use common\modules\UploadHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
        <?php
        $status = User::getStatusAsArray();
        $role = User::getRoleAsArray();
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'Avatar',
                    'value' => UploadHelper::getImageUrl('user/' . $model->id, 'small',[],true),
                    'format' => 'image'
                ],
                'username',
                'email:email',
                [
                    'label' => 'Status',
                    'value' => $status[$model->status]
                ],
                [
                    'label' => 'Role',
                    'value' => $role[$model->role]
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>


</div>
