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
<div class="thumbnail">
	<?= Html::a(
		UploadHelper::getHtml( $types[$model->type_id] . '/' . $model->id, 'medium'),
		['/partner/view', 'id' => $model->id]
) ?>
	<div class="caption">
		<h3>
			<?=$model->title?>
		</h3>
	</div>
</div>
