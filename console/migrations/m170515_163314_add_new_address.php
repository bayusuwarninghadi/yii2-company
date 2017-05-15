<?php

use yii\db\Migration;
use common\models\Pages;
use common\models\PagesLang;

class m170515_163314_add_new_address extends Migration
{
    public function up()
    {
	    $this->insert(Pages::tableName(),[
		    'camel_case' => 'AddressMap'
	    ]);
	    $this->insert(PagesLang::tableName(), [
		    'title' => 'Address Map',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);

    }

    public function down()
    {
    }
}
