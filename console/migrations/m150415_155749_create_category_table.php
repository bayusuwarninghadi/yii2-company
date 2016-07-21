<?php

use yii\db\Schema;
use yii\db\Migration;

class m150415_155749_create_category_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('category',[
            'id' => Schema::TYPE_PK,
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
            'tree' => Schema::TYPE_INTEGER,
            'lft' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_by' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
        ]);
        
        $this->createTable('category_lang', [
            'id' => Schema::TYPE_PK,
            'cat_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'language' => Schema::TYPE_STRING . " NOT NULL DEFAULT 'en-US'",
        ]);

        $this->addForeignKey('category_lang_to_category', 'category_lang', 'cat_id', 'category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('page_to_category', 'pages', 'cat_id', 'category', 'id', 'CASCADE', 'CASCADE');

        $this->insert('category',[
            'tree' => 1,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('category_lang_to_category', 'category_lang');
        $this->dropForeignKey('page_to_category', 'pages');
        $this->dropTable('category');
    }
    
}
