<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category[] */
?>
<ul class="nav categories-tree" role="navigation">
	<?php foreach ($model as $category) : ?>
		<li>			
			<?php if ($_child = $category->children(1)->all()) : ?>
				<a href="#"><i class="fa fa-th-large fa-fw"></i> <?=$category->name?> <span class="fa arrow"></span></a>
				<div class="btn-group btn-group-sm hide">
			        <?= Html::a('<i class="fa fa-users fa-fw"></i> Add Child', ['create', 'prepend' => $category->id], ['class' => 'btn btn-success'])?>
			        <?= Html::a('<i class="fa fa-user fa-fw"></i> Insert After', ['create', 'after' => $category->id], ['class' => 'btn btn-success'])?>
			        <?= Html::a('<i class="fa fa-pencil fa-fw"></i> Edit', ['update', 'id' => $category->id], ['class' => 'btn btn-warning'])?>
			        <?= Html::a('<i class="fa fa-trash fa-fw"></i> Delete', ['delete', 'id' => $category->id], [
			            'class' => 'btn btn-danger',
			            'data' => [
			                'confirm' => 'Are you sure you want to delete this item?',
			                'method' => 'post',
			            ],
			        ]) ?>
				</div>
				<?= $this->render('_list', ['model' => $_child])?>
			<?php else : ?>
				<a href="#"><i class="fa fa-th-large fa-fw"></i> <?=$category->name?></a>
				<div class="btn-group btn-group-sm hide">
			        <?= Html::a('<i class="fa fa-users fa-fw"></i> Add Child', ['create', 'prepend' => $category->id], ['class' => 'btn btn-success'])?>
			        <?= Html::a('<i class="fa fa-user fa-fw"></i> Insert After', ['create', 'after' => $category->id], ['class' => 'btn btn-success'])?>
			        <?= Html::a('<i class="fa fa-pencil fa-fw"></i> Edit', ['update', 'id' => $category->id], ['class' => 'btn btn-warning'])?>
			        <?= Html::a('<i class="fa fa-trash fa-fw"></i> Delete', ['delete', 'id' => $category->id], [
			            'class' => 'btn btn-danger',
			            'data' => [
			                'confirm' => 'Are you sure you want to delete this item?',
			                'method' => 'post',
			            ],
			        ]) ?>
				</div>
			<?php endif ?>
		</li>
	<?php endforeach ?>
</ul>