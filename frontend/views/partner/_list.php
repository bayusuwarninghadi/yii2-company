<?php
use common\modules\UploadHelper;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 20:03
 * @var $model \common\models\Pages
 */

?>
<div class="portfolio-item">
	<?= Html::a(
        '<div class="portfolio-hover">
            <div class="portfolio-hover-content">
                '. Yii::t('app','see detail').'
            </div>
        </div>
        ' .
		UploadHelper::getHtml( $model->getImagePath(), 'medium', ['class' => 'img-responsive']),
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
