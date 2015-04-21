<?php

use yii\db\Migration;
use yii\db\Schema;

class m150421_164926_create_user_favorite extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_favorite', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'product_id' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey('user_favorite_to_user', 'user_favorite', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('user_favorite_to_product', 'user_favorite', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('user_favorite_to_user','user_favorite');
        $this->dropForeignKey('user_favorite_to_product','user_favorite');
        $this->dropTable('user_favorite');
    }
}
