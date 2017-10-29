<?php

use yii\helpers\HtmlPurifier;
use yii\helpers\Inflector;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\modules\UploadHelper;

/* @var $this yii\web\View */
/* @var $model \common\models\Pages */

$this->title = Inflector::camel2words($model->title);
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-5">
				<?= Breadcrumbs::widget([
					'links' => $this->params['breadcrumbs'],
				]); ?>
            </div>
        </div>
    </div>
</div>
<section class="container">
    <div class="col-sm-10">
        <div class="form-group">
            <?=UploadHelper::getHtml($model->getImagePath(), 'large', ['class' => 'img-responsive'])?>
        </div>
        <?=HtmlPurifier::process($model->description)?>
    </div>
</section>
