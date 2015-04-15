<?php

use yii\db\Schema;
use yii\db\Migration;

class m150415_154631_create_cart_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('cart',[
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_SMALLINT . ' NOT NULL',
        ]);
        $this->addForeignKey('cart_to_user', 'cart', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('cart_to_product', 'cart', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('cart_to_user', 'cart');
        $this->dropForeignKey('cart_to_product', 'cart');
        $this->dropTable('cart');
    }
}
