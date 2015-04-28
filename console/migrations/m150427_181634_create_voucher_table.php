<?php

use yii\db\Migration;
use yii\db\Schema;

class m150427_181634_create_voucher_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('voucher', [
            'id' => Schema::TYPE_PK,
            'voucher_code' => Schema::TYPE_STRING,
            'value' => Schema::TYPE_BIGINT . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'expired_at' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey('transaction_to_voucher', 'transaction', 'voucher_id', 'voucher', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('transaction_to_voucher', 'transaction');
        $this->dropTable('voucher');
    }
}
