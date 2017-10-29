<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;
use yii\helpers\Url;

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
			<?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?>
            <br>
        </h3>
        <div class="description">
			<?= HtmlPurifier::process(substr($model->description, 0, 200)) ?>
        </div>
    </div>
    <div class="ribbon">
	    <?php foreach (Json::decode($model->pageTags->value) as $index => $tag) :?>

            <a href="<?=Url::to(['/partner', 'PagesSearch[tags]' => $tag])?>" class="new">
                <div class="theribbon" style="font-weight: 100"><?=$tag?></div>
            </a>
            <?php if ($index == 0) break;?>
	    <?php endforeach; ?>

    </div>

</div>