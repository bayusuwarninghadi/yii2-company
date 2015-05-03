<?php

use yii\db\Schema;
use yii\db\Migration;

class m150415_155749_create_category_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('category',[
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'tree' => Schema::TYPE_INTEGER,
            'lft' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        $this->insert('category',[
            'name' => 'Category',
            'description' => 'Category',
            'tree' => 1,
            'lft' => 1,
            'rgt' => 1,
            'depth' => 0,
        ]);

        $this->addForeignKey('product_to_category', 'product', 'cat_id', 'category', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('product_to_category', 'product');
        $this->dropTable('category');
    }
    
}
