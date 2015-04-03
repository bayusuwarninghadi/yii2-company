<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 12/5/14
 * Time: 14:45
 */

namespace backend\widget;


use yii\grid\ActionColumn as BaseActionColumn;
use Yii;
use yii\helpers\Html;

/**
 * Class ActionColumn
 * @package common\component\module
 */
class ActionColumn extends BaseActionColumn{


    /**
     * @var string the header cell content. Note that it will not be HTML-encoded.
     */
    public $header = 'Options';

    /**
     * @var array the HTML attributes for the column group tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [ 'width' => '140px' ];

    /**
     * @var string the template used for composing each cell in the action column.
     * Tokens enclosed within curly brackets are treated as controller action IDs (also called *button names*
     * in the context of action column). They will be replaced by the corresponding button rendering callbacks
     * specified in [[buttons]]. For example, the token `{view}` will be replaced by the result of
     * the callback `buttons['view']`. If a callback cannot be found, the token will be replaced with an empty string.
     * @see buttons
     */
    public $template = '<div class="text-center"><div class="btn-group" role="group">{view} {update} {delete}</div></div>';

    /**
     * @var bool
     */
    public $viewAjax = false;

    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model) {
                return Html::a('<i class="fa fa-search"></i>', $url, [
                    'title' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                    'data-ajax' => $this->viewAjax ? '1' : false,
                    'class' => 'btn btn-info btn-sm btn-view-ajax',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model) {
                return Html::a('<i class="fa fa-pencil"></i>', $url, [
                    'title' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-warning btn-sm'
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('<i class="fa fa-trash"></i>', $url, [
                    'title' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'class' => 'btn btn-danger btn-sm'
                ]);
            };
        }
    }

} 