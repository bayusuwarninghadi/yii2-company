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
/* @var $tags array */

/* @var $searchModel common\models\PagesSearch */

?>

<div class="hidden-xs form-group">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>
    <div class="row">
        <div class="form-group pull-left">
		    <?php
		    $get = Yii::$app->request->get('PagesSearch');
		    ?>

            <ul class="nav nav-pills">
			    <?php foreach ($tags as $tag): ?>
				    <?php
				    $tag = trim($tag);
				    $isActive = boolval(isset($get['tag']) && $get['tag'] == $tag); ?>
                    <li class="<?php if ($isActive) echo 'active' ?>">
					    <?php
					    ?>
                        <a class="text-capitalize" href="?PagesSearch%5Btag%5D=<?= $tag ?>">
						    <?= $tag ?>
                        </a>
                    </li>
			    <?php endforeach; ?>
                <li class="<?php if (empty($get) || empty($get['tag'])) echo 'active' ?>">
                    <a href="?PagesSearch%5Btag%5D=">
					    <?= Yii::t('app', 'All') ?>
                    </a>
                </li>

            </ul>
        </div>
        <div class="input-group pull-right" style="width: 200px">
		    <?= Html::activeTextInput($searchModel, 'key', ['class' => 'form-control']) ?>
            <span class="input-group-btn">
		    <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary']) ?>
		</span>
        </div>

    </div>
	<?php ActiveForm::end(); ?>
</div>

