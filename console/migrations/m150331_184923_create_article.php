<?php

use yii\db\Schema;
use yii\db\Migration;

class m150331_184923_create_article extends Migration
{    
    public function safeUp()
    {
        $this->createTable('article',[
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'order' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }
    
    public function safeDown()
    {
        $this->dropTable('article');
    }
}
