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

?>
<div class="product">
    <div class="image">
		<?= Html::a(
			UploadHelper::getHtml($model->getImagePath(), 'medium', ['class' => 'img-responsive image1']),
			['view', 'id' => $model->id]
		) ?>
    </div>
    <div class="text">
        <h3>
	        <?= Html::a( Html::encode($model->title), ['view', 'id' => $model->id]) ?>
        </h3>
        <p class="price"><?= Html::encode($model->subtitle) ?></p>
        <p>
	        <?= HtmlPurifier::process(substr($model->description, 0, 200)) ?>
        </p>
    </div>
    <div class="ribbon sale">
        <div class="theribbon">SALE</div>
        <div class="ribbon-background"></div>
    </div>
    <div class="ribbon new">
        <div class="theribbon">NEW</div>
        <div class="ribbon-background"></div>
    </div>
</div>