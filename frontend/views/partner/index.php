<?php

use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var array $tags */
/* @var $header \common\models\Pages */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partner';
$this->params['breadcrumbs'][] = $this->title;
if ($searchModel->tags) {
	foreach ($searchModel->tags as $tag){
		$this->params['breadcrumbs'][] = [
			'label' => $tag,
			'url' => ['/partner', 'PagesSearch[tags]' => $tag],
		];
	}
}
?>
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Our Partner</h1>
            </div>
            <div class="col-md-5">
				<?= Breadcrumbs::widget([
					'links' => $this->params['breadcrumbs'],
				]); ?>
            </div>
        </div>
    </div>
</div>

<div id="content" class="container">
    <p class="text-muted lead">
		<?= HtmlPurifier::process($header->description) ?>
    </p>

	<?php
	Pjax::begin();
	echo ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_list',
		'layout' => "<div class='row products'>{items}</div>{pager}",
		'itemOptions' => [
			'class' => 'col-md-3 col-sm-4'
		]
	]);
	Pjax::end();
	?>
</div>
