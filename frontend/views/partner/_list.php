<?php
use common\modules\UploadHelper;
use yii\helpers\Html;
use common\models\Pages;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/17/15
 * Time: 20:03
 * @var $model \common\models\Pages
 */

$types = Pages::getTypeAsArray()
?>
<?= Html::a(
    UploadHelper::getHtml( $types[$model->type_id] . '/' . $model->id, 'medium', ['style' => 'width: 200px;']),
    ['view', 'id' => $model->id],
    ['class' => 'thumbnail']
) ?>
