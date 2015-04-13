<?php

use yii\db\Schema;
use yii\db\Migration;

class m150413_191219_create_request_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('request',[
            'id' => 'pk',
            'user_id' => Schema::TYPE_INTEGER,
            'merchant_id' => Schema::TYPE_INTEGER,
            'controller' => Schema::TYPE_STRING,
            'action' => Schema::TYPE_STRING,
            'related_parameters' => Schema::TYPE_STRING,
            'from_device' => Schema::TYPE_STRING,
            'from_ip' => Schema::TYPE_STRING,
            'from_latitude' => Schema::TYPE_STRING,
            'from_longitude' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable("request");
    }
}
