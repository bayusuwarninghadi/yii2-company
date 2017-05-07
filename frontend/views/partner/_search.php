<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/7/17
 * Time: 13:18
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */

?>

<div class="hidden-xs form-group">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>
    <div class="input-group">
		<?= Html::activeTextInput($searchModel, 'key', ['class' => 'form-control']) ?>
        <span class="input-group-btn">
		    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
		</span>
    </div>
	<?php ActiveForm::end(); ?>
</div>

