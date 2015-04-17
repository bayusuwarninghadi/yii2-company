<?php

use yii\db\Migration;
use yii\db\Schema;

class m150417_072300_create_shipping_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('shipping', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'address' => Schema::TYPE_STRING . ' NOT NULL',
            'city' => Schema::TYPE_STRING . ' NOT NULL',
            'postal_code' => Schema::TYPE_SMALLINT,
        ]);
        $this->addForeignKey('shipping_to_user', 'shipping', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('shipping_to_user', 'shipping');
        $this->dropTable('shipping');
    }
}
