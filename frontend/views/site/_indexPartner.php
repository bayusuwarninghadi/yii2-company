<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/1/17
 * Time: 18:02
 *
 * @var $models \common\models\Pages[]
 */

use yii\helpers\Html;
use yii\bootstrap\Carousel;
use common\modules\UploadHelper;

?>
<section class="bg-light-gray" id="partner">
    <div class="container-fluid">
        <div class="text-center">
            <h2 class="section-heading">
				<?= Yii::t('app', 'Partners') ?>
            </h2>
            <h3 class="section-subheading text-muted">
				<?= Yii::t('app', 'Kami bermitra dengan regulator dan seluruh ekosistem industri untuk mendorong masa depan keuangan berorientasi teknologi') ?>
            </h3>
        </div>
        <div class="form-group controls-box text-right">
            <!-- Controls -->
            <div class="controls btn-group">
                <a class="left fa fa-chevron-left btn btn-default" href="#partner-slider" data-slide="prev"></a>
                <a class="right fa fa-chevron-right btn btn-default" href="#partner-slider" data-slide="next"></a>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
		$items = [];
		foreach ($models as $model) {
			$items[] =
				Html::beginTag('div', ['class' => 'col-md-3 col-xs-6']) .
				Html::beginTag('div', ['class' => 'portfolio-item portfolio-item-fix-height']) .
				Html::a('<div class="portfolio-hover">
                        <div class="portfolio-hover-content text-uppercase">
                            '. Yii::t('app','see detail').'
                        </div>
                    </div>
                    <div class="square-fix-300 bg-cover img m-auto" style="background-image: url('.UploadHelper::getImageUrl('partner/' . $model->id, 'medium', ['class' => 'img-responsive']).')"></div>
                    ',
					['/partner/view', 'id' => $model->id],
					[
						'class' => 'portfolio-link'
					]
				) .
				Html::beginTag('div', ['class' => 'portfolio-caption']) .
				Html::tag('h4', $model->title) .
				Html::tag('p', $model->subtitle, ['class' => 'text-muted']) .
				Html::endTag('div') .
				Html::endTag('div') .
				Html::endTag('div');
		}

		$items = array_chunk($items, 4);

		$partnerSliders = [];

		foreach ($items as $row) {
			$element = Html::beginTag('div', ['class' => 'row']);
			foreach ($row as $item) {
				$element .= $item;
			}
			$element .= Html::endTag('div');
			$partnerSliders[] = $element;
		}

		?>
		<?= Carousel::widget([
			'items' => $partnerSliders,
			'options' => [
				'class' => 'slide',
				'id' => 'partner-slider',
			],
			'showIndicators' => false,
			'controls' => false
		]) ?>

        <div class="text-center">
			<?= Html::a('See More', ['/partner'], ['class' => 'btn btn-primary btn-lg']) ?>
        </div>
    </div>
</section>
