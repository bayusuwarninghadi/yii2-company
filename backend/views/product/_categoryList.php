<?php

/* @var $this yii\web\View */
/* @var $model common\models\Category[] */
/* @var $level integer */
?>
<ul class="nav categories-tree" role="navigation">
	<?php foreach ($model as $category) : ?>
		<li>			
			<?php if ($_child = $category->children(1)->all()) : ?>
				<a href="#" style="padding-left: <?=($level*15)?>px"><i class="fa fa-th-large fa-fw"></i> <?=$category->name?> <span class="fa arrow"></span></a>
				<?= $this->render('_categoryOption', ['category' => $category])?>
				<?= $this->render('_categoryList', ['model' => $_child, 'level' => ($level + 1)])?>
			<?php else : ?>
				<a href="#" style="padding-left: <?=($level*15)?>px"><i class="fa fa-th-large fa-fw"></i> <?=$category->name?></a>
				<?= $this->render('_categoryOption', ['category' => $category])?>
            <?php endif ?>
		</li>
	<?php endforeach ?>
</ul>