<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/1/17
 * Time: 18:02
 *
 * @var $indexPartner \common\models\Pages
 * @var $models \common\models\Pages[]
 */

use yii\helpers\Html;
use common\modules\UploadHelper;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

?>
<section class="bg-light-gray" id="partner">
    <div class="container-fluid">
        <div class="text-center">
            <h2 class="section-heading">
				<?= Yii::t('app', 'Partners') ?>
            </h2>
            <h3 class="section-subheading text-muted">
	            <?= HtmlPurifier::process($indexPartner->description) ?>
            </h3>
        </div>
        <div class="row">
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
            <?php endforeach ?>
        </div>
        <div class="text-center">
			<?= Html::a('See More', ['/partner'], ['class' => 'btn btn-primary btn-lg']) ?>
        </div>
    </div>
</section>
