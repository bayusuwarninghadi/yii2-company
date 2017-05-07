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
use yii\helpers\Url;

?>
<section id="article" class="bg-light-gray">
    <div class="container">
        <div class="text-center form-group">
            <h2 class="section-heading"><?= Yii::t('app', 'Article') ?></h2>
            <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
        <div class="row">
			<?php foreach ($models as $model): ?>
                <div class="col-sm-4">
                    <div class="team-member">
                        <a href="<?=Url::to(['/news/view', 'id' => $model->id])?>">
                            <div class="square-fix-300 bg-cover img-circle img m-auto"
                                 style="background-image: url(<?=UploadHelper::getImageUrl('news/' . $model->id, 'medium')?>)"></div>
                        </a>
                        <h3>
							<?= Html::encode($model->title) ?>
                            <br>
                            <small>
								<?= Html::encode($model->subtitle) ?>
                                <br>
                                <small class="text-muted"><?= Yii::$app->formatter->asDate($model->updated_at) ?></small>
                            </small>
                        </h3>
                        <p class="text-muted">
							<?= HtmlPurifier::process(substr($model->description, 0, 200)) ?>
                        </p>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
    </div>
</section>