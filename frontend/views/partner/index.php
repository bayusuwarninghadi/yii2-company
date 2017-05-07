<?php

use yii\widgets\Pjax;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section">
    <div class="text-center">

        <h1 class="section-heading">
			<?= Yii::t('app', 'Partners') ?>
        </h1>
        <h3 class="section-subheading text-muted">
			<?= Yii::t('app', 'Kami bermitra dengan regulator dan seluruh ekosistem industri untuk mendorong masa depan keuangan berorientasi teknologi') ?>
        </h3>
    </div>
</section>
<section class="small-section bg-light-gray">
    <div class="container">
        <?php
		Pjax::begin();
		echo ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_list',
			'layout' => $this->render('_search', [
					'searchModel' => $searchModel
				]) . "<br><div class='container-fluid'><div class='grid row'>{items}</div></div>{pager}",
			'itemOptions' => [
				'class' => 'grid-item col-sm-3'
			]
		]);
		Pjax::end();
		?>

    </div>
</section>
