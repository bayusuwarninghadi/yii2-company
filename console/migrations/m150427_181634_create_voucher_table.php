<?php

use yii\db\Migration;
use yii\db\Schema;

class m150427_181634_create_voucher_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('voucher', [
            'id' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_BIGINT . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'expired_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (`id`)'
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('voucher');
    }
}
