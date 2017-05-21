<?php

use yii\db\Migration;
use common\models\Pages;
use common\models\PagesLang;

class m170521_143911_add_new_reset_password_mail extends Migration
{
    public function up()
    {
	    $this->insert(Pages::tableName(),[
		    'camel_case' => 'Register',
		    'type_id' => Pages::TYPE_MAIL
	    ]);

	    $this->insert(PagesLang::tableName(), [
		    'title' => 'Register',
		    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.',
		    'page_id' => Yii::$app->db->getLastInsertID(),
	    ]);

    }

    public function down()
    {
    }
}
