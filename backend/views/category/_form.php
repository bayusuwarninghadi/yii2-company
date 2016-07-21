<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\tinymce\TinyMce;
use yii\bootstrap\Tabs;
use common\models\Category;
use common\modules\UploadHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelEnglish common\models\PagesLang */
/* @var $modelIndonesia common\models\PagesLang */

?>

<div class="category-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?=$model->isNewRecord ? 'Create' : 'Update'?></div>
        <div class="panel-body">
            <?= $form->field($model, 'type_id')->dropDownList(Category::getTypeAsArray(),['id' => 'type-id-input']) ?>
            <?= $form->field($model, 'url')->textInput(['id' => 'url-input'])?>
            <?= $form->field($model, 'image',[
                'template' => Html::tag('div', UploadHelper::getHtml('category/' . $model->id, 'small')) .
                    "{label}\n{input}\n{hint}\n{error}"
            ])->fileInput(['class' => 'btn btn-default form-control', 'accept' => 'image/*']);?>

            <?php

            $tinyMceConfig = \Yii::$app->modules['tiny-mce'];
            $items = [];

            $tinyMceConfig['options']['name'] = 'modelEnglish[description]';
            $items[] = [
                'label' => 'English',
                'content' =>
                    $form->field($modelEnglish, 'title')->textInput(['maxlength' => 255, 'name' => 'modelEnglish[title]']) .
                    $form->field($modelEnglish, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];
            $tinyMceConfig['options']['name'] = 'modelIndonesia[description]';
            $items[] = [
                'label' => 'Indonesia',
                'content' =>
                    $form->field($modelIndonesia, 'title')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[title]']) .
                    $form->field($modelIndonesia, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];

            echo Tabs::widget([
                'items' => $items
            ]);
            ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php $this->registerJs('
var change_url = function(){
    $("#url-input").toggleClass("hidden", $("#type-id-input").val() != "'. Category::TYPE_URL.'")    
};
change_url();
$("#type-id-input").change(function(){
    change_url();
});
')?>
