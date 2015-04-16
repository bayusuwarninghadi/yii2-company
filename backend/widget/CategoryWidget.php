<?php
namespace backend\widget;

use yii\widgets\InputWidget;
use common\models\Category;
use yii\helpers\Html;

class CategoryWidget extends InputWidget{


	public function run(){
		$id = $this->getId();
        echo Html::beginTag('div', ['class' => 'category-tree-container','id' => $id]);
		echo $this->renderCategory(Category::find()->roots()->all());
        echo Html::activeHiddenInput($this->model, $this->attribute);
		echo Html::endTag('div');
		$view = $this->getView();
		$view->registerCss(".category-tree-container { border:1px solid #ccc; border-top: none } .category-tree-container a { border-top:1px solid #ccc }");
		$view->registerJs("jQuery('#$id>ul').metisMenu();");
		$input_id = Html::getInputId($this->model, $this->attribute);
		$view->registerJs("
			jQuery('.category-tree-container a').click(function(){
				jQuery('#$input_id').val($(this).data('id'))
			});");
	}
	protected function renderCategory($categories, $level = 1){
		echo Html::beginTag('ul', ['class' => 'nav categories-tree','role' => 'navigation']);
		foreach ($categories as $category) {
			echo Html::beginTag('li');
			$paddingLeft = $level*15;
			if ($_child = $category->children(1)->all()){
				echo Html::a('+ '.$category->name.' <i class="fa arrow"></i>','#',['data-id' => $category->id, 'style' => 'padding-left:'.$paddingLeft.'px']);
				echo $this->renderCategory($_child, $level + 1);
			} else {
				echo Html::a('+ '.$category->name,'#',['data-id' => $category->id, 'style' => 'padding-left:'.$paddingLeft.'px']);
			}
			echo Html::endTag('li');
		}
		echo Html::endTag('ul');

	}
}