<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\bootstrap\Carousel;
use yii\helpers\Json;

/* @var string $this */
/* @var $this yii\web\View */
/* @var $model common\models\Pages|common\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
				<?php
				if ($model->pageImages) {
				    $images = [];
					foreach ($model->pageImages as $image) {
						$_arr = Json::decode($image->value);
						$images[] = Html::img(Yii::$app->components['frontendSiteUrl'] . $_arr['large']);
					}

					echo Carousel::widget([
						'items' => $images,
						'options' => [
							'class' => 'slide'
						],
						'controls' => [
							'<span class="glyphicon glyphicon-chevron-left"></span>',
							'<span class="glyphicon glyphicon-chevron-right"></span>',
						]
					]);
				} elseif ($model->pageImage){
                    echo UploadHelper::getHtml($model->getImagePath(), 'large', ['class' => 'img-responsive']);
                }
				?>
                <h1><?= Html::encode($this->title) ?></h1>
                <h4 class="page-header">
                    <small>
                        <i class="fa fa-fw fa-calendar"></i> <?= \Yii::$app->formatter->asDate($model->updated_at) ?>
                    </small>
                </h4>
                <div class="pull-left" style="width: 50px;">
                    <div class="form-group">
						<?= Html::a('<i class="fa fa-facebook fa-fw fa-lg"></i>', 'http://www.facebook.com/sharer.php?u=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-primary btn-circle']) ?>
                    </div>
                    <div class="form-group">
						<?= Html::a('<i class="fa fa-twitter fa-fw fa-lg"></i>', 'http://twitter.com/share?url=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-info btn-circle']) ?>
                    </div>
                    <div class="form-group">
						<?= Html::a('<i class="fa fa-google-plus fa-fw fa-lg"></i>', 'https://plus.google.com/share?url=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-danger btn-circle']) ?>
                    </div>
                    <div class="form-group">
						<?= Html::a('<i class="fa fa-envelope fa-fw fa-lg"></i>', 'mailto:?Subject=' . Html::decode($model->title) . '&body=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-warning btn-circle']) ?>
                    </div>
                </div>
                <div style="display: inline">
					<?= HTMLPurifier::process($model->description) ?>
                </div>
            </div>
        </div>
    </div>
</section>