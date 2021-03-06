<?php

use yii\db\Migration;
use common\models\Pages;
use common\models\PagesLang;

class m170521_142413_add_new_register_mail extends Migration
{
    public function up()
    {
	    $this->insert(Pages::tableName(),[
		    'camel_case' => 'ResetPassword',
		    'type_id' => Pages::TYPE_MAIL
	    ]);

	    $this->insert(PagesLang::tableName(), [
		    'title' => 'ResetPassword',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);
    }

    public function down()
    {
    }
}
