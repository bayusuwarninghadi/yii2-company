<?php

use yii\db\Migration;

class m170515_151741_add_new_latlong extends Migration
{
    public function up()
    {
	    $this->insert('setting',[
		    'key' => 'latitude_longitude',
		    'value' => '-6.216013, 106.801467',
	    ]);
	    $this->insert('setting',[
		    'key' => 'google_api_key',
		    'value' => 'AIzaSyDR5jtSM3Q6yXPhNzxiy2_a1u9DgyO4d-s',
	    ]);
    }

    public function down()
    {
    }
}
