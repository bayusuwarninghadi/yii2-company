<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = \Yii::t('app', 'Contact Us');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_contact', [
	'model' => $model
]) ?>
