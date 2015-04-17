<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 20:03
 * @var $model \common\models\Article
 */

?>
<h2>
    <?= Html::encode($model->title) ?>
    <small><?=Html::a('View More',['view', 'id' => $model->id])?></small>
</h2>
<?= HtmlPurifier::process(substr($model->description,0,200)) ?>
<p>
    <i class="fa fa-fw fa-calendar"></i> <?=Yii::$app->formatter->asDate($model->updated_at)?>
</p>
