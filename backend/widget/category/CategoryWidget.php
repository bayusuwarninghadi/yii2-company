<?php
namespace backend\widget\category;

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class CategoryWidget
 * @package backend\widget
 */
class CategoryWidget extends InputWidget
{

    /**
     * @var bool
     */
    public $withPanel = true;
    /**
     * @var bool
     */
    public $renderOption = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        CategoryWidgetAssets::register($this->view);
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        if ($this->withPanel) {
            echo Html::beginTag('div', ['class' => 'panel panel-primary']);
            echo Html::tag('div', '<b>Select Category</b>', ['class' => 'panel-heading']);
            static::runElement();
            echo Html::endTag('div');
        } else {
            static::runElement();
        }
    }

    /**
     * run main element
     */
    protected function runElement()
    {
        $id = $this->getId();

        echo Html::getAttributeValue($this->model, $this->attribute);
        echo Html::beginTag('div', ['class' => 'category-tree-container', 'id' => $id]);
        static::renderCategory(Category::find()->roots()->all());
        echo Html::activeHiddenInput($this->model, $this->attribute);
        echo Html::endTag('div');

        $view = $this->getView();
        $view->registerCss(".category-tree-container a { border-top:1px solid #ccc }");
        $view->registerJs("jQuery('#$id>ul').metisMenu();");

        $input_id = Html::getInputId($this->model, $this->attribute);
        $view->registerJs("
			jQuery('.category-tree-container li > a').click(function(){
				jQuery('#$input_id').val($(this).data('id'));
				return false;
			});");
    }

    /**
     * Render Category Tree
     *
     * @param Category[] $categories
     * @param int $level
     */
    protected function renderCategory($categories, $level = 1)
    {
        echo Html::beginTag('ul', ['class' => 'nav categories-tree', 'role' => 'navigation']);
        foreach ($categories as $category) {
            echo Html::beginTag('li');
            $paddingLeft = $level * 15;
            if ($_child = $category->children(1)->all()) {
                echo Html::a('+ ' . $category->name . ' <i class="fa arrow"></i>', '#', ['data-id' => $category->id, 'style' => 'padding-left:' . $paddingLeft . 'px']);
                if ($this->renderOption) {
                    static::renderOption($category);
                }
                static::renderCategory($_child, $level + 1);
            } else {
                echo Html::a('+ ' . $category->name, '#', ['data-id' => $category->id, 'style' => 'padding-left:' . $paddingLeft . 'px']);
                if ($this->renderOption) {
                    static::renderOption($category);
                }
            }
            echo Html::endTag('li');
        }
        echo Html::endTag('ul');
    }

    /**
     * Render Options
     * @param $category
     */
    protected function renderOption($category)
    {
        echo Html::beginTag('div', ['class' => 'btn-group btn-group-sm hide']);
        echo Html::a('Add Child', ['create', 'prepend' => $category->id], ['class' => 'btn btn-primary']);
        echo Html::a('Insert After', ['create', 'after' => $category->id], ['class' => 'btn btn-success']);
        echo Html::a('Edit', ['update', 'id' => $category->id], ['class' => 'btn btn-warning']);
        echo Html::a('Delete', ['delete', 'id' => $category->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
        echo Html::endTag('div');
    }

}