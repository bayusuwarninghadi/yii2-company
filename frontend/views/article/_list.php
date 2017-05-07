<?php
use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\models\Pages;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 20:03
 * @var $model \common\models\Pages
 */

$types = Pages::getTypeAsArray()
?>
<div class="portfolio-item">
	<?= Html::a(
		'<div class="portfolio-hover">
            <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
            </div>
        </div>
        ' .
		UploadHelper::getHtml( $types[$model->type_id] . '/' . $model->id, 'medium', ['class' => 'img-responsive']),
		['view', 'id' => $model->id],
		[
			'class' => 'portfolio-link'
		]
	) ?>
    <div class="portfolio-caption">
        <h3 class="m0">
		    <?= Html::encode($model->title) ?>
        </h3>
        <h4 class="text-thin m0"><?= Html::encode($model->subtitle) ?></h4>
        <p class="text-muted">
            <i class="fa fa-fw fa-calendar"></i> <?= \Yii::$app->formatter->asDate($model->updated_at) ?>
        </p>
        <hr>
        <p class="text-muted">
            <small><?= HtmlPurifier::process(substr($model->description, 0, 200)) ?> ... </small>
        </p>

    </div>
</div>
