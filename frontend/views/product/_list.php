<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 20:03
 * @var $model \common\models\Pages
 */

?>
<div class="product">
    <div class="ribbon">
		<?php if ($model->discount > 0) : ?>
            <div class="sale">
                <div class="theribbon">SALE <?=$model->discount?>%</div>
            </div>
		<?php endif; ?>
		<?php if ($model->order == 0) : ?>
            <div class="new">
                <div class="theribbon">NEW</div>
            </div>
		<?php endif; ?>
    </div>

    <div class="image">
		<?= Html::a(
			UploadHelper::getHtml($model->getImagePath(), 'medium', ['class' => 'img-responsive image1']),
			['view', 'id' => $model->id]
		) ?>
    </div>
    <div class="text">
        <h3>
			<?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?>
            <br>
        </h3>
        <div class="description">
			<?= HtmlPurifier::process(substr($model->description, 0, 200)) ?>
        </div>
    </div>
</div>