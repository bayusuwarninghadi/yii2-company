<?php
use yii\bootstrap\Carousel;
use common\modules\UploadHelper;
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/23/15
 * Time: 00:53
 * 
 * @var $brands \common\models\Brand[]
 */
?>
<div class="panel panel-default">
	  <div class="panel-body">
          <?php
          $items = [];

          foreach ($brands as $_item) {
              if ($image = UploadHelper::getHtml('brand/' . $_item->id, 'medium')) {
                  $items[] = $image;
              }
          }

          echo Carousel::widget([
              'items' => $items,
              'options' => [
                  'id' => 'brand-slider',
                  'class' => 'slide'
              ],
              'showIndicators' => false,
              'controls' => false
          ]);
          ?>
      </div>
    <div class="panel-footer">
        <div class="controls pull-right btn-group btn-group-xs">
            <a class="left fa fa-chevron-left btn btn-default" href="#brand-slider" data-slide="prev"></a>
            <a class="right fa fa-chevron-right btn btn-default" href="#brand-slider" data-slide="next"></a>
        </div>
        <strong>OUR BRAND</strong>
        <div class="clearfix"></div>
    </div>
</div>
