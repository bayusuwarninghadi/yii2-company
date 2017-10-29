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

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
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
		'layout' => "<div id='blog-listing-medium'>{items}</div>{pager}",
	]);
	Pjax::end();
	?>
</div>
