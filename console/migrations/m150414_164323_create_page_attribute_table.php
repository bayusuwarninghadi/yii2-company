<?php

use yii\db\Schema;
use yii\db\Migration;

class m150414_164323_create_page_attribute_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('page_attribute',[
            'id' => 'pk',
            'page_id' => Schema::TYPE_INTEGER,
            'key' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('page_attribute_to_pages','page_attribute','page_id','pages','id','CASCADE','CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('page_attribute_to_pages','page_attribute');
        $this->dropTable('page_attribute');
    }
    
}
