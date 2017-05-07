<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var string $this */
/* @var $this yii\web\View */
/* @var $model common\models\Pages|common\models\Category */
/* @var string $type */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <h1><?= Html::encode($this->title) ?></h1>
                <h4 class="page-header">
		            <?=$model->user->username?><br>
                    <small>
                        <i class="fa fa-fw fa-calendar"></i> <?= \Yii::$app->formatter->asDate($model->updated_at) ?>
                    </small>
                </h4>
                <div style="display: inline">
		            <?= HTMLPurifier::process($model->description) ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>