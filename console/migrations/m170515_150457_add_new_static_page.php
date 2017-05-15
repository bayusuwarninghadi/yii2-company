<?php

use yii\db\Migration;
use common\models\Pages;
use common\models\PagesLang;
class m170515_150457_add_new_static_page extends Migration
{
    public function up()
    {
	    $this->insert(Pages::tableName(),[
		    'camel_case' => 'PartnerHeader'
	    ]);
	    $this->insert(PagesLang::tableName(), [
		    'title' => 'Partner Header',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);
	    $this->insert(Pages::tableName(),[
		    'camel_case' => 'NewsHeader'
	    ]);
	    $this->insert(PagesLang::tableName(), [
		    'title' => 'NewsHeader',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);
	    $this->insert(Pages::tableName(),[
		    'camel_case' => 'ArticleHeader'
	    ]);
	    $this->insert(PagesLang::tableName(), [
		    'title' => 'ArticleHeader',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);
    }

    public function down()
    {
    }
}
