<?php

use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;
use common\models\Pages;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var array $tags */
/* @var $header \common\models\Pages */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partner';
$this->params['breadcrumbs'][] = $this->title;
if ($searchModel->tags) {
	foreach ($searchModel->tags as $tag){
		$this->params['breadcrumbs'][] = [
			'label' => $tag,
			'url' => ['/partner', 'PagesSearch[tags]' => $tag],
		];
	}
}
?>
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Our Partner</h1>
            </div>
            <div class="col-md-5">
				<?= Breadcrumbs::widget([
					'links' => $this->params['breadcrumbs'],
				]); ?>
            </div>
        </div>
    </div>
</div>

<div id="content" class="container">
    <p class="text-muted lead">
		<?= HtmlPurifier::process($header->description) ?>
    </p>

    <div class="row">
        <div class="col-sm-9">
	        <?php
	        Pjax::begin();
	        echo ListView::widget([
		        'dataProvider' => $dataProvider,
		        'itemView' => '_list',
		        'layout' => "<div class='row products'>{items}</div>{pager}",
		        'itemOptions' => [
			        'class' => 'col-md-4 col-sm-6'
		        ]
	        ]);
	        Pjax::end();
	        ?>
        </div>
        <div class="col-sm-3">
		    <?php $form = ActiveForm::begin([
			    'action' => ['index'],
			    'method' => 'get',
		    ]); ?>
            <div class="panel panel-default sidebar-menu">
                <div class="panel-body">
                    <div class=""></div>
				    <?= $form->field($searchModel, 'key', ['template' => "{input}\n{hint}\n{error}"])->textInput(['placeholder' => 'Search ...']) ?>
                </div>

                <div class="panel-heading">
                    <h3 class="panel-title">Tags</h3>
                    <button type='button'
                            class='btn btn-xs btn-danger pull-right'
                            data-container-target='#tags-container'
                            data-toggle='checkbox'>
                        <i class="fa fa-times-circle"></i>
                        <span class="hidden-sm">Clear</span>
                    </button>
                </div>
                <div class="panel-body" id="tags-container">
                    <ul class="tag-cloud category-menu">
					    <?php foreach (Pages::getAvailableTags(Pages::PAGE_ATTRIBUTE_TAGS, Pages::TYPE_PARTNER) as $tag) : ?>
                            <li class="<?php if (in_array($tag, $searchModel->tags)) echo 'active' ?>">
                                <a href="#">
                                    <input type="checkbox" class="hidden" name="PagesSearch[tags][]" value="<?=$tag?>" <?php if (in_array($tag, $searchModel->tags)) echo 'checked="checked"' ?>>
                                    <i class="fa fa-tags"></i> <?= Inflector::camel2words($tag) ?>
                                </a>
                            </li>
					    <?php endforeach ?>
                    </ul>
                </div>
            </div>

            <div class="form-group">
			    <?= Html::submitButton('<i class="fa fa-pencil"></i> Search', ['class' => 'btn btn-default btn-sm btn-template-main']) ?>
            </div>
		    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
