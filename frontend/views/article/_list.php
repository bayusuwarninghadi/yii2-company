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
<div class="media ">

	<?= Html::a(
		UploadHelper::getHtml( $types[$model->type_id] . '/' . $model->id, 'medium', ['style' => 'width: 200px;']),
		['view', 'id' => $model->id],
		['class' => 'media-left']
	) ?>
    <div class="media-body">
        <h4>
			<?= Html::encode($model->title) ?>
			<small><?= Html::encode($model->subtitle) ?></small>
        </h4>
        <hr>
        <i class="fa fa-fw fa-calendar"></i> <?= \Yii::$app->formatter->asDate($model->updated_at) ?>
        <?= HtmlPurifier::process(substr($model->description, 0, 200)) ?>
        <small><?= Html::a(\Yii::t('app', 'View More'), ['view', 'id' => $model->id]) ?></small>
    </div>
</div>

