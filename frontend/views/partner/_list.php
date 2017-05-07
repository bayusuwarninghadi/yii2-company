<?php
use common\modules\UploadHelper;
use yii\helpers\Html;
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
		['/partner/view', 'id' => $model->id],
        [
            'class' => 'portfolio-link'
        ]
) ?>
	<div class="portfolio-caption">
		<h4><?=$model->title?></h4>
        <p class="text-muted"><?=$model->subtitle?></p>
	</div>
</div>
