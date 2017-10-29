<?php

use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\Pages;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var array $tags */
/* @var $header \common\models\Pages */
/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1><?=Yii::t('app', 'Get latest news')?></h1>
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
					    <?php foreach (Pages::getAvailableTags(Pages::PAGE_ATTRIBUTE_TAGS, Pages::TYPE_NEWS) as $tag) : ?>
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
        <div class="col-sm-9">
		    <?php
		    Pjax::begin();
		    echo ListView::widget([
			    'dataProvider' => $dataProvider,
			    'itemView' => '_list',
			    'layout' => "<div id='blog-listing-medium'>{items}</div>{pager}",
		    ]);
		    Pjax::end();
		    ?>
        </div>
    </div>


</div>

<?=$this->registerJs("
    $('.category-menu a').click(function (ev) {
        var _parent = $(this).closest('li');
        _parent.toggleClass('active');
        _parent.find('input[type=\"checkbox\"]').prop(\"checked\", _parent.hasClass('active'));
        return false;
    })
")?>