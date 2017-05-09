<?php

use yii\db\Migration;
use common\models\Pages;
use common\models\PagesLang;

class m170509_035105_add_pill_fields_to_pages extends Migration
{
    public function up()
    {
	    $this->insert(Pages::tableName(),[
		    'type_id' => Pages::TYPE_PILL,
		    'camel_case' => 'IndexPill1'
	    ]);
	    $this->insert(PagesLang::tableName(), [
		    'title' => 'Header Pill 1',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);
	    $this->insert(Pages::tableName(),[
		    'type_id' => Pages::TYPE_PILL,
		    'camel_case' => 'IndexPill2'
	    ]);
	    $this->insert(PagesLang::tableName(), [
		    'title' => 'Header Pill 2',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);
	    $this->insert(Pages::tableName(),[
		    'type_id' => Pages::TYPE_PILL,
		    'camel_case' => 'IndexPill3'
	    ]);
	    $this->insert(PagesLang::tableName(), [
		    'title' => 'Header Pill 3',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);
    }

    public function down()
    {
    	Pages::deleteAll([
    		'camel_case' => [
    			'IndexPill1',
    			'IndexPill2',
    			'IndexPill3',
		    ]
	    ]);
    }

}
