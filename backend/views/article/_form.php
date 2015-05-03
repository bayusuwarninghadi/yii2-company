<?php

use backend\widget\tinymce\TinyMce;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $articleEnglish common\models\ArticleLang */
/* @var $articleIndonesia common\models\ArticleLang */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="article-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-yellow">
        <div class="panel-heading"><i class="fa fa-pencil fa-fw"></i> <?= $model->isNewRecord ? 'Create' : 'Update' ?>
        </div>
        <div class="panel-body">
            <?php

            $tinyMceConfig = Yii::$app->modules['tiny-mce'];
            $items = [];

            $tinyMceConfig['options']['name'] = 'articleEnglish[description]';
            $items[] = [
                'label' => 'English',
                'content' =>
                    $form->field($articleEnglish, 'title')->textInput(['maxlength' => 255, 'name' => 'articleEnglish[title]']) .
                    $form->field($articleEnglish, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];
            $tinyMceConfig['options']['name'] = 'articleIndonesia[description]';
            $items[] = [
                'label' => 'Indonesia',
                'content' =>
                    $form->field($articleIndonesia, 'title')->textInput(['maxlength' => 255, 'name' => 'articleIndonesia[title]']) .
                    $form->field($articleIndonesia, 'description')->widget(TinyMce::className(), $tinyMceConfig),
            ];

            echo Tabs::widget([
                'items' => $items
            ]);
            ?>
            <?= $form->field($model, 'order')->input('order') ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
