<?php

use backend\widget\tinymce\TinyMce;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\UploadHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $modelEnglish common\models\PagesLang */
/* @var $modelIndonesia common\models\PagesLang */
/* @var $form yii\widgets\ActiveForm */
/* @var string $type */

?>

<div class="article-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?= $model->isNewRecord ? 'Create' : 'Update' ?>
        </div>
        <div class="panel-body">
            <?= $form->field($model, 'image',[
                'template' => ($model->pageImage ? Html::tag('div', UploadHelper::getHtml('page/' . $model->id . '/' . $model->pageImage->id, 'small')) : "") .
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
                    $form->field($modelEnglish, 'subtitle')->textInput(['maxlength' => 255, 'name' => 'modelEnglish[subtitle]']) .
                    $form->field($modelEnglish, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];
            $tinyMceConfig['options']['name'] = 'modelIndonesia[description]';
            $items[] = [
                'label' => 'Indonesia',
                'content' =>
                    $form->field($modelIndonesia, 'title')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[title]']) .
                    $form->field($modelIndonesia, 'subtitle')->textInput(['maxlength' => 255, 'name' => 'modelIndonesia[subtitle]']) .
                    $form->field($modelIndonesia, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];


            echo Tabs::widget([
                'items' => $items
            ]);
            ?>
            <?= $form->field($model, 'pageTags[value]')->textInput()->label(Yii::t('app', 'Tags, separate by comma')) ?>
            <?= $form->field($model, 'order')->input('number') ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
