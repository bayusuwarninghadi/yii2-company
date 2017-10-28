<?php

use yii\db\Migration;

class m171028_073204_update_page_attributes extends Migration
{
    public function up()
    {
	    $table = Yii::$app->db->schema->getTableSchema('pages');
	    if(isset($table->columns['subtitle'])) {
		    $this->dropColumn('pages', 'subtitle');
	    }

	    $this->insert('setting',[
		    'key' => 'background_1',
		    'type' => \common\models\Setting::TYPE_IMAGE_INPUT
	    ]);

	    $this->insert('setting',[
		    'key' => 'background_2',
		    'type' => \common\models\Setting::TYPE_IMAGE_INPUT
	    ]);

	    $this->insert('setting',[
		    'key' => 'background_3',
		    'type' => \common\models\Setting::TYPE_IMAGE_INPUT,
		    ''
	    ]);

    }

    public function down()
    {
    }
}
