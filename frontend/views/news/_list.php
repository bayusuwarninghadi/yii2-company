<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 20:03
 * @var $model \common\models\Pages
 */

?>
<section class="post">
    <div class="row">
        <div class="col-md-4">
            <div class="image" style="height: 197px;">
				<?= Html::a(
					UploadHelper::getHtml($model->getImagePath(), 'medium', ['class' => 'img-responsive']),
					['view', 'id' => $model->id]
				) ?>
            </div>
        </div>
        <div class="col-md-8">
            <h2><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?></h2>
            <div class="clearfix">
                <p class="author-category">
                    Tags
					<?php foreach (Json::decode($model->pageTags->value) as $index => $tag) : ?>
						<?= Html::a($tag, ['news', 'PagesSearch[tags]' => $tag], ['class' => 'text-primary']) ?>
					<?php endforeach; ?>
                </p>
                <p class="date-comments">
                    <i class="fa fa-calendar-o"></i> <?= Yii::$app->formatter->asRelativeTime($model->updated_at) ?>
                </p>
            </div>
            <p class="intro"><?= HtmlPurifier::process(substr($model->description, 0, 500)) ?></p>
            <p class="read-more">
				<?= Html::a('Continue reading', ['view', 'id' => $model->id], ['class' => 'btn btn-template-main']) ?>
            </p>
        </div>
    </div>
</section>