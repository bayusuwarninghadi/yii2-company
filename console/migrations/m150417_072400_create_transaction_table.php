<?php

use yii\db\Migration;
use yii\db\Schema;

class m150417_072400_create_transaction_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('transaction', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'shipping_id' => Schema::TYPE_INTEGER,
            'note' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'sub_total' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
            'grand_total' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
        ]);
        $this->addForeignKey('transaction_to_user', 'transaction', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('transaction_to_shipping', 'transaction', 'shipping_id', 'shipping', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('transaction_to_shipping', 'transaction');
        $this->dropForeignKey('transaction_to_user', 'transaction');
        $this->dropTable('transaction');
    }

}
