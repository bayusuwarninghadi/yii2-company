<?php

use yii\db\Migration;
use yii\db\Schema;

class m150423_111716_create_confirmation_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('confirmation', [
            'id' => Schema::TYPE_PK,
            'transaction_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'payment_method' => Schema::TYPE_STRING . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'amount' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
            'note' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_DATE . ' NOT NULL'
        ]);
        $this->addForeignKey('confirmation_to_transaction', 'confirmation', 'transaction_id', 'transaction', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('confirmation_to_user', 'confirmation', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('confirmation_to_transaction', 'confirmation');
        $this->dropForeignKey('confirmation_to_user', 'confirmation');
        $this->dropTable('confirmation');
    }
}
