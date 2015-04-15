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
				<?= $this->render('_list', ['model' => $_child])?>
			<?php else : ?>
				<a href="#"><i class="fa fa-th-large fa-fw"></i> <?=$category->name?></a>
			<?php endif ?>
		</li>
	<?php endforeach ?>
</ul>