<?php

use yii\db\Migration;
use yii\db\Schema;

class m150421_164926_create_user_attribute extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_attribute', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'key' => Schema::TYPE_STRING,
            'value' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('user_attribute_to_user', 'user_attribute', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('user_attribute_to_user','user_attribute');
        $this->dropTable('user_attribute');
    }
}
