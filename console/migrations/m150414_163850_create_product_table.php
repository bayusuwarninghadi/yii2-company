<?php

use yii\db\Schema;
use yii\db\Migration;

class m150414_163850_create_product_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('product',[
            'id' => 'pk',
            'cat_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'price' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
            'discount' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'stock' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'visible' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'order' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('product');
    }
    
}
