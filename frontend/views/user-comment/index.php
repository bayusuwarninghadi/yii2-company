<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 04:06
 *
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\UserComment $model
 */
?>
<div class="row">
    <div class="col-sm-8">
        <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_list',
            'separator' => '<hr/>',
            'layout' => '<div class="panel panel-default"><div class="panel-heading">{summary}</div><div class="panel-body">{items}</div>{pager}</div>',
        ]);
        ?>
    </div>
    <div class="col-sm-4">
        <?php
        if (Yii::$app->user->isGuest) {
            echo Html::a('Login To Comment', '/site/login');
        } else {
            $form = ActiveForm::begin();
            echo $form->field($model, 'rating')->dropDownList([5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1]);
            echo $form->field($model, 'title');
            echo $form->field($model, 'comment')->textarea(['rows' => 6]);
            echo Html::submitButton('Post Comment', ['class' => 'btn btn-primary']);
            $form->end();
        }
        ?>
    </div>
</div>

