<?php

use yii\db\Schema;
use yii\db\Migration;

class m150413_174741_create_setting_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('setting',[
            'id' => Schema::TYPE_PK,
            'key' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_TEXT,
            'readonly' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('setting');
    }
}
