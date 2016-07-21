<?php

use backend\widget\category\CategoryWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'id' => 'product-search'
]); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <i class="fa fa-search"></i> <?=\Yii::t('app','Advance Search')?>
    </div>
    <div class="panel-product-search">
        <div class="category-tree-container">
            <ul class="nav categories-tree collapse">
                <li>
                    <a class="<?php if ($model->cat_id == '') echo 'active'?>" href="#" data-id="" style="padding-left:15px">+ <?=\Yii::t('app','All Category')?></a>
                </li>
            </ul>
        </div>
        <?= $form->field($model, 'cat_id', ['template' => "{input}\n{hint}\n{error}", 'options' => ['class' => '']])->widget(CategoryWidget::className(), ['withPanel' => false]) ?>
    </div>
    <div class="panel-footer text-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>



