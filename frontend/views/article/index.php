<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var string $type */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="small-section">
    <div class="text-center">
        <h1 class="section-heading">
			<?= Yii::t('app', 'News') ?>
        </h1>
        <h3 class="section-subheading text-muted">
			<?= Yii::t('app', 'Kami bermitra dengan regulator dan seluruh ekosistem industri untuk mendorong masa depan keuangan berorientasi teknologi') ?>
        </h3>
    </div>
</section>

<section class="bg-light-gray small-section">
    <div class="container">
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
	    <?php
	    Pjax::begin();
	    echo ListView::widget([
		    'dataProvider' => $dataProvider,
		    'itemView' => '_list',
		    'layout' => "{items}{pager}",
		    'itemOptions' => [
			    'class' => 'list-group-item'
		    ]
	    ]);
	    Pjax::end();
	    ?>

    </div>
</section>