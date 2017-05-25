<?php

use yii\db\Migration;

class m170525_071809_add_footer_text extends Migration
{
    public function up()
    {
	    $this->insert('setting',[
		    'key' => 'footer_text',
		    'value' => 'My Company 2017',
	    ]);
    }

    public function down()
    {
    }
}
