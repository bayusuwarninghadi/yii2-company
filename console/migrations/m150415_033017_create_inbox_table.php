<?php

use yii\db\Schema;
use yii\db\Migration;

class m150415_033017_create_inbox_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('inbox', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'subject' => Schema::TYPE_STRING . ' NOT NULL',
            'message' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ]);
    }

    public function safeDow()
    {
        $this->dropTable('inbox');
    }
    
}
