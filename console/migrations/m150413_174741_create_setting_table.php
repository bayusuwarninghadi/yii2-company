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
            'type' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'readonly' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
        ]);
        $this->insert('setting',[
            'key' => 'site_name',
            'value' => 'My Company',
        ]);
        $this->insert('setting',[
            'key' => 'admin_email',
            'value' => 'admin@email.com',
        ]);
        $this->insert('setting',[
            'key' => 'facebook_url',
            'value' => 'http://facebook.com',
        ]);
        $this->insert('setting',[
            'key' => 'twitter_url',
            'value' => 'http://twitter.com',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('setting');
    }
}
