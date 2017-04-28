<?php
/**
 * Created by PhpStorm.
 * User: bayu
 * Date: 4/28/17
 * Time: 10:54 AM
 * @var $newsFeeds \common\models\Pages[]
 */

use common\modules\UploadHelper;
use yii\helpers\HtmlPurifier;

?>
<section>
    <div class="container">
        <div class="text-center form-group">
            <h2 class="section-heading"><?= Yii::t('app', 'News Feed') ?></h2>
            <h3 class="section-subheading text-muted"><?= Yii::t('app', 'Read Our Latest News') ?></h3>
        </div>
        <hr>
        <ul class="timeline">
            <?php foreach ($newsFeeds as $key => $feed) : ?>
                <li class="<?= (($key % 2) == 0) ? 'timeline-inverted' : '' ?>">
                    <div class="timeline-image">
                        <?= UploadHelper::getHtml('news/' . $feed->id, 'medium', ['class' => 'img-circle img-responsive']) ?>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>
                                <?= $feed->title ?>
                                <hr style="margin: 5px 0;">
                                <small class="text-muted"><?= Yii::$app->formatter->asDate($feed->updated_at) ?></small>
                            </h4>
                        </div>
                        <div class="timeline-body">
                            <?= HtmlPurifier::process(substr($feed->description, 0, 200)) ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>