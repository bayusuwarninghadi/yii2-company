<?php
namespace backend\widget\category;

use common\models\Category;
use creocoder\nestedsets\NestedSetsBehavior;
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
    public $options = false;

    /**
     * @var array
     */
    protected $selected = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        CategoryWidgetAssets::register($this->view);
        $selected = Html::getAttributeValue($this->model, $this->attribute);
        $this->selected[] = $selected;
        /** @var Category|NestedSetsBehavior $currentCategory*/
        if ($currentCategory = Category::findOne($selected)){
            /** @var Category|NestedSetsBehavior $parent*/
            foreach ($currentCategory->parents()->all() as $parent){
                $this->selected[] = $parent->id;
            }
        }
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

        echo Html::beginTag('div', ['class' => 'category-tree-container', 'id' => $id]);
        echo Html::activeHiddenInput($this->model, $this->attribute);
        /**
         * assuming first row is root
         * @var Category|NestedSetsBehavior $root
         */
        $root = Category::find()->one();
        if ($root->isRoot()) {
            static::renderCategory($root->children(1)->all());
        }
        $view = $this->getView();
        $view->registerJs("jQuery('#$id>ul').metisMenu();");
        $input_id = Html::getInputId($this->model, $this->attribute);
        $view->registerJs("
            jQuery('#$id li>a').click(function(){
                $('#$id li>a').removeClass('active');
                $(this).addClass('active')
                jQuery('#$input_id').val($(this).data('id'));return false;
            });
        ");
        echo Html::endTag('div');

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
        /** @var NestedSetsBehavior|Category $category */
        foreach ($categories as $category) {
            echo Html::beginTag('li');
            $paddingLeft = $level * 15;
            if ($_child = $category->children(1)->all()) {
                echo Html::a('+ ' . $category->title . ' <i class="fa arrow"></i>', '#',
                    [
                        'data-id' => $category->id,
                        'style' => 'padding-left:' . $paddingLeft . 'px',
                        'class' => in_array($category->id, $this->selected) ? 'active' : ''
                    ]
                );
                if ($this->options) {
                    static::renderOptions($category);
                }
                static::renderCategory($_child, $level + 1);
            } else {
                echo Html::a('+ ' . $category->title, '#',
                    [
                        'data-id' => $category->id,
                        'style' => 'padding-left:' . $paddingLeft . 'px',
                        'class' => in_array($category->id, $this->selected) ? 'active' : ''
                    ]
                );
                if ($this->options) {
                    static::renderOptions($category);
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
    protected function renderOptions($category)
    {
        echo Html::beginTag('div', ['class' => 'btn-group btn-group-sm hide']);
        echo Html::a('<i class="fa fa-fw fa-level-down"></i>', ['create', 'node' => 'prepend', 'node-id' => $category->id], ['class' => 'btn btn-success', 'title' => 'Insert sub category']);
        echo Html::a('<i class="fa fa-fw fa-arrow-up"></i>', ['create', 'node' => 'before', 'node-id' => $category->id], ['class' => 'btn btn-success', 'title' => 'Insert before this category']);
        echo Html::a('<i class="fa fa-fw fa-arrow-down"></i>', ['create', 'node' => 'after', 'node-id' => $category->id], ['class' => 'btn btn-success', 'title' => 'Insert after this category']);
        echo Html::a('<i class="fa fa-fw fa-edit"></i>', ['update', 'id' => $category->id], ['class' => 'btn btn-primary', 'title' => 'Edit category']);
        echo Html::a('<i class="fa fa-fw fa-trash-o"></i>', ['delete', 'id' => $category->id], [
            'class' => 'btn btn-danger',
            'title' => 'Delete category',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
        echo Html::endTag('div');
    }

}