<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/22/17
 * Time: 09:51
 *
 * @var $models \common\models\Pages[]
 * @var $this \yii\web\View
 */

use yii\helpers\Url;
use common\modules\UploadHelper;
?>
<?php foreach ($models as $model) :?>
		<div class="col-sm-3 col-xs-12">
			<div class="portfolio-item portfolio-item-fix-height">
				<a href="<?=Url::to(['/partner/view', 'id' => $model->id])?>" class="portfolio-link">
					<div class="portfolio-hover">
						<div class="portfolio-hover-content text-uppercase">
							<?=Yii::t('app','see detail')?>
						</div>
					</div>
					<div class="square-fix-300 bg-cover img m-auto"
					     style="background-image: url('<?=UploadHelper::getImageUrl($model->getImagePath(), 'medium', ['class' => 'img-responsive'])?>')">
					</div>
				</a>
				<div class="portfolio-caption">
					<h4><?=$model->title?></h4>
					<p class="text-muted"><?=$model->subtitle?></p>
				</div>
			</div>
		</div>
<?php endforeach; ?>
