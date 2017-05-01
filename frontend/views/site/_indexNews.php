<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/1/17
 * Time: 18:03
 *
 * @var $models \common\models\Pages[]
 */

use common\modules\UploadHelper;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

?>
<section>
    <div class="container">
        <div class="text-center form-group">
            <h2 class="section-heading"><?= Yii::t('app', 'News Feed') ?></h2>
            <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
        <div class="row">
		    <?php foreach ($models as $model): ?>
                <div class="col-sm-4 col-md-3">
                    <div class="thumbnail" style="padding: 0; border: 1px solid #eee;">
					    <?= Html::a(
						    UploadHelper::getHtml('news/' . $model->id, 'medium'),
						    ['view', 'id' => $model->id]
					    ) ?>
                        <div class="caption text-center">
                            <h3>
							    <?= Html::encode($model->title) ?>
                                <br>
                                <small><?= Html::encode($model->subtitle) ?></small>
                            </h3>
	                        <?= HtmlPurifier::process(substr($model->description, 0, 200)) ?>
                        </div>
                    </div>
                </div>
		    <?php endforeach; ?>
        </div>
    </div>
</section>
