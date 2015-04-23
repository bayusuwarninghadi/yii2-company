<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/19/15
 * Time: 17:16
 *
 * @var $this \yii\web\View
 * @var $models \common\models\Product[]
 * @var $model \common\models\Product
 */

$this->title = "Related Product ".$model->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<?php foreach ($models as $model) :?>
    <div class="col-md-3 col-xs-6">
        <?=$this->render('/product/_list',[
            'model' => $model
        ])?>
    </div>
<?php endforeach ?>
