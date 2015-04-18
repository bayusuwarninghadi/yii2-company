<?php

use yii\db\Schema;
use yii\db\Migration;

class m150414_164323_create_product_attribute_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('product_attribute',[
            'id' => 'pk',
            'product_id' => Schema::TYPE_INTEGER,
            'key' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('product_attribute_to_product','product_attribute','product_id','product','id','CASCADE','CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('product_attribute_to_product','product_attribute');
        $this->dropTable('product_attribute');
    }
    
}
