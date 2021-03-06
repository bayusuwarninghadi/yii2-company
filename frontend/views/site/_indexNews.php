<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/1/17
 * Time: 18:03
 *
 * @var $indexNews \common\models\Pages
 * @var $models \common\models\Pages[]
 */

use common\modules\UploadHelper;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

?>
<section id="news">
    <div class="container">
        <div class="text-center form-group">
            <h2 class="section-heading"><?= Yii::t('app', 'Latest News') ?></h2>
            <h3 class="section-subheading text-muted">
	            <?= HtmlPurifier::process($indexNews->description) ?>
            </h3>
        </div>
        <div class="row">
            <ul class="timeline">
		        <?php foreach ($models as $key => $feed) :?>
                    <li class="<?=(($key % 2) == 0) ? 'timeline-inverted' : ''?>">
                        <div class="timeline-image bg-cover" style="background-image: url('<?=UploadHelper::getImageUrl('news/' . $feed->id, 'medium', ['class' => 'img-circle img-responsive'])?>')">
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>
							        <?=$feed->title?>
                                    <small><?=$feed->subtitle?></small>
                                    <hr style="margin: 5px 0 0;">
                                    <small class="text-muted"><?=Yii::$app->formatter->asDate($feed->created_at)?></small>
                                </h4>
                            </div>
                            <div class="timeline-body">
						        <?= HtmlPurifier::process(substr($feed->description, 0, 200)) ?>
                            </div>
                        </div>
                    </li>
		        <?php endforeach; ?>
                <li class="timeline-inverted">
                    <div class="timeline-image">
	                    <?=Html::a('<h4>Be part<br>of our<br>news</h4>', ['/news'], ['style' => 'color:white'])?>
                    </div>
                </li>
            </ul>
            <div class="text-center">

            </div>
        </div>
    </div>
</section>