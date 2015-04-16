<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category[] */
/* @var $level integer */
?>
<ul class="nav categories-tree" role="navigation">
	<?php foreach ($model as $category) : ?>
		<li>			
			<?php if ($_child = $category->children(1)->all()) : ?>
				<a href="#" style="padding-left: <?=($level*15)?>px"><?=$category->name?> <span class="fa arrow"></span></a>
				<div class="btn-group btn-group-sm hide">
			        <?= Html::a('<i class="fa fa-users fa-fw"></i>', ['create', 'prepend' => $category->id], ['class' => 'btn btn-primary', 'title' => 'Add Child'])?>
			        <?= Html::a('<i class="fa fa-user fa-fw"></i>', ['create', 'after' => $category->id], ['class' => 'btn btn-success', 'title' => 'Insert After This Category'])?>
			        <?= Html::a('<i class="fa fa-pencil fa-fw"></i>', ['update', 'id' => $category->id], ['class' => 'btn btn-warning', 'title' => 'Edit This Category'])?>
			        <?= Html::a('<i class="fa fa-trash fa-fw"></i>', ['delete', 'id' => $category->id], [
			            'class' => 'btn btn-danger',
			            'data' => [
			                'confirm' => 'Are you sure you want to delete this item?',
			                'method' => 'post',
			            ],
                        'title' => 'Delete This Category'
			        ]) ?>
				</div>
				<?= $this->render('_list', ['model' => $_child, 'level' => ($level + 1)])?>
			<?php else : ?>
				<a href="#" style="padding-left: <?=($level*15)?>px"><?=$category->name?></a>
                <div class="btn-group btn-group-sm hide">
                    <?= Html::a('<i class="fa fa-users fa-fw"></i>', ['create', 'prepend' => $category->id], ['class' => 'btn btn-primary', 'title' => 'Add Child'])?>
                    <?= Html::a('<i class="fa fa-user fa-fw"></i>', ['create', 'after' => $category->id], ['class' => 'btn btn-success', 'title' => 'Insert After This Category'])?>
                    <?= Html::a('<i class="fa fa-pencil fa-fw"></i>', ['update', 'id' => $category->id], ['class' => 'btn btn-warning', 'title' => 'Edit This Category'])?>
                    <?= Html::a('<i class="fa fa-trash fa-fw"></i>', ['delete', 'id' => $category->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                        'title' => 'Delete This Category'
                    ]) ?>
                </div>
            <?php endif ?>
		</li>
	<?php endforeach ?>
</ul>