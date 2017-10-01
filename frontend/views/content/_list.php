<?php
use common\modules\UploadHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 20:03
 * @var $model \common\models\Pages
 */

?>
<?= Html::a(
    UploadHelper::getHtml($model->getImagePath(), 'medium', ['style' => 'width: 200px;']),
    ['view', 'id' => $model->id],
    ['class' => 'media-left']
) ?>
<div class="media-body">
    <h4>
        <?= Html::encode($model->title) ?>
        <small><?= Html::a(\Yii::t('app', 'View More'), ['view', 'id' => $model->id]) ?></small>
    </h4>
    <?= HtmlPurifier::process(substr($model->description, 0, 200)) ?>
    <p>
        <i class="fa fa-fw fa-calendar"></i> <?= \Yii::$app->formatter->asDate($model->updated_at) ?>
    </p>
</div>

