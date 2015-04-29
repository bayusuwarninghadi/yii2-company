<?php
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/19/15
 * Time: 22:59
 *
 * @var $model \common\models\Shipping
 * @var $this \yii\web\View
 */

$this->title = Yii::t('app', 'Update') . ' ' . $model->cityArea->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app','Profile'),
    'url' => ['user/index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::decode($this->title) ?></h1>
<?= $this->render('_formShipping', [
    'model' => $model
]) ?>