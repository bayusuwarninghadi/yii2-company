<?php
use yii\helpers\Html;
use backend\widget\chart\Morris;
/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<h1 class="page-header"><?= Html::encode($this->title) ?></h1>
<div class="panel panel-primary">
      <div class="panel-heading">
            <h3 class="panel-title">Api Request</h3>
      </div>
      <div class="panel-body">
            <?php
            echo Morris::widget([
                'type' => 'Bar',
                'options' => [
                    'data' => [
                        [
                            'period' => 'January',
                            'iphone' => 5670,
                            'ipad' => 14293,
                        ], 
                        [
                            'period' => 'February',
                            'iphone' => 4820,
                            'ipad' => 3795,
                        ], 
                        [
                            'period' => 'Maret',
                            'iphone' => 15073,
                            'ipad' => 5967,
                        ], 
                        [
                            'period' => 'April',
                            'iphone' => 30687,
                            'ipad' => 4460,
                        ], 
                        [
                            'period' => 'Mei',
                            'iphone' => 8432,
                            'ipad' => 5713,
                        ]
                    ],
                    'xkey' => 'period',
                    'ykeys' => ['iphone', 'ipad'],
                    'labels' => ['iPhone', 'iPad'],
                    'pointSize' => 2,
                    'hideHover' => 'auto',
                    'resize' => true
                ]
            ]);
            ?>
      </div>
</div>