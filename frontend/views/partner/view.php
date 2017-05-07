<?php

use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var string $this */
/* @var $this yii\web\View */
/* @var $model common\models\Pages|common\models\Pages */
/* @var string $type */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <div class="row">
        <div class="col-sm-9">
            <?=UploadHelper::getHtml( $type . '/' . $model->id, 'large',['class' => 'img-responsive'])?>
            <h1><?= Html::encode($this->title) ?></h1>
            <h4 class="page-header">
                <?=$model->subtitle?><br>
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
                    <?= Html::a('<i class="fa fa-envelope fa-fw fa-lg"></i>', 'mailto:?Subject='.Html::decode($model->title).'&body=' . \Yii::$app->request->getAbsoluteUrl(), ['class' => 'btn btn-warning btn-circle']) ?>
                </div>
            </div>
            <div style="display: inline">
                <?= HTMLPurifier::process($model->description) ?>
            </div>
            <div class="clearfix"></div>
            <h4 class="page-header"><?=\Yii::t('app','User Comments')?></h4>
            <div class="user-comment-view list-group-item">
                <?=Html::tag('div', $this->render('/layouts/_loading'), [
                    'class' => 'comment-container',
                    'data-id' => $model->id,
                    'data-key' => 'partner'
                ])?>
            </div>

        </div>
    </div>
</div>