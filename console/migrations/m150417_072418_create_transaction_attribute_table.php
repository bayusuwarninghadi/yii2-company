<?php

use yii\db\Migration;
use yii\db\Schema;

class m150417_072418_create_transaction_attribute_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('transaction_attribute', [
            'id' => Schema::TYPE_PK,
            'transaction_id' => Schema::TYPE_INTEGER,
            'product_id' => Schema::TYPE_INTEGER,
            'product_attribute' => Schema::TYPE_TEXT,
            'current_price' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
            'current_discount' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
        ]);
        $this->addForeignKey('transaction_attribute_to_transaction', 'transaction_attribute', 'transaction_id', 'transaction', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('transaction_attribute_to_product', 'transaction_attribute', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('transaction_attribute_to_transaction', 'transaction_attribute');
        $this->dropForeignKey('transaction_attribute_to_product', 'transaction_attribute');
        $this->dropTable('transaction_attribute');
    }

}
