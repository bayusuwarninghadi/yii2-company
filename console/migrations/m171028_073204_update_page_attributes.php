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
	    foreach (\common\models\Pages::find()->all() as $item){
	    	$item->save();
	    }
    }

    public function down()
    {
    }
}
