<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var string $type */
/* @var array $tags */
/* @var $header \common\models\Pages */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section">
    <div class="text-center">
        <h1 class="section-heading">
			<?= Yii::t('app', $type) ?>
        </h1>
        <h3 class="section-subheading text-muted">
	        <?= HtmlPurifier::process($header->description) ?>
        </h3>
    </div>
</section>

<section class="bg-light-gray small-section">
    <div class="container-fluid">
        <div class="form-group">
			<?php $form = ActiveForm::begin([
				'action' => ['index'],
				'method' => 'get',
			]); ?>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2 form-group">
			        <?= Html::activeDropDownList($searchModel, 'tag', array_combine($tags, $tags), ['class' => 'form-control text-capitalize', 'prompt' => 'All Topics']) ?>
                </div>
                <div class="col-sm-3 form-group">
			        <?= Html::activeTextInput($searchModel, 'key', ['class' => 'form-control', 'placeholder' => 'search']) ?>
                </div>
                <div class="col-sm-2 form-group">
			        <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>
			<?php ActiveForm::end(); ?>
        </div>
		<?php
		Pjax::begin();
		echo ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_list',
			'layout' => "<div class='grid'>{items}</div>{pager}",
			'itemOptions' => [
				'class' => 'grid-item col-sm-4'
			]
		]);
		Pjax::end();
		?>
    </div>
</section>