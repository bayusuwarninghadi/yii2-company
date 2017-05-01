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
use common\modules\UploadHelper;
use yii\bootstrap\Carousel;

?>
<section class="bg-light-gray">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading">
				<?= Yii::t('app', 'Partners') ?>
            </h2>
            <h3 class="section-subheading text-muted">
				<?= Yii::t('app', 'Kami bermitra dengan regulator dan seluruh ekosistem industri untuk mendorong masa depan keuangan berorientasi teknologi') ?>
            </h3>
        </div>
        <div class="row">
			<?php
            $items = [];
            foreach ($models as $model){
                $list = Html::beginTag('div', ['class' => 'item']);
                $list = Html::beginTag('div', ['class' => 'col-md-3']);
                $list .= Html::a(
	                UploadHelper::getHtml('partner/' . $model->id, 'medium'),
	                ['view', 'id' => $model->id]
                );
                $list .= Html::endTag('div');
                $list .= Html::endTag('div');
	            $items[] = $list;
            }
            ?>
            <?=Carousel::widget([
                'items' => $items,
                'options' => [
                    'class' => 'carousel  slide'
                ]
            ])?>
        </div>
    </div>
</section>
