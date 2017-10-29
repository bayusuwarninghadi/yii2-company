<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */
/* @var $contactPopup \common\models\Pages */

$this->title = \Yii::t('app', 'Contact Us');
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

<?= $this->render('_contact', [
	'model' => $model,
	'contactPopup' => $contactPopup,
]) ?>
