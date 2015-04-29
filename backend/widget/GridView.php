<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 2/18/15
 * Time: 02:30
 */

namespace backend\widget;

use yii\grid\GridView as BaseGridView;
use yii\grid\GridViewAsset;
use yii\helpers\Json;

/**
 * Class GridView
 * @package common\gilkor\component
 */
class GridView extends BaseGridView{

    /**
     * @var string
     */
    public $panelHeading = '<span class="glyphicon glyphicon-list"></span> Listing';

    /**
     * @var string
     */
    public $panelBefore = '';

    /**
     * @var string
     */
    public $panelType = 'panel-primary';

    /**
     * @var string
     */
    public $panelAfter = '';

    /**
     * @var string
     */
    public $panelFooter = '';

    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{errors}`: the filter model error summary. See [[renderErrors()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = "
        <div class='panel {panelType}'>
            <div class='panel-heading'>
                {panelHeading}
                <div class='pull-right'>{summary}</div>
                <div class='clearfix'></div>
            </div>
            {panelBefore}
            <div class='table-container'>
                {items}
            </div>
            <div class='panel-body'>
                <div class='grid-pagination'>{pager}</div>
            </div>
            {panelAfter}
            {panelFooter}
        </div>
    ";


    /**
     * Runs the widget.
     */
    public function run()
    {
        $id = $this->options['id'];
        $this->renderPanel();
        $options = Json::encode($this->getClientOptions());
        $view = $this->getView();
        GridViewAsset::register($view);
        $view->registerJs("jQuery('#$id').yiiGridView($options);");
        parent::run();
    }

    /**
     * render new panel
     */
    protected function renderPanel(){

        if ($this->panelBefore != ''){
            $this->panelBefore = '<div class="panel-body">'.$this->panelBefore.'</div>';
        }
        if ($this->panelAfter != ''){
            $this->panelAfter = '<div class="panel-body">'.$this->panelAfter.'</div>';
        }
        if ($this->panelFooter != ''){
            $this->panelFooter = '<div class="panel-footer">'.$this->panelFooter.'</div>';
        }
        $this->layout = strtr(
            $this->layout,
            [
                '{panelType}' => $this->panelType,
                '{panelHeading}' => $this->panelHeading,
                '{panelBefore}' => $this->panelBefore,
                '{panelAfter}' => $this->panelAfter,
                '{panelFooter}' => $this->panelFooter,
            ]
        );
    }
}