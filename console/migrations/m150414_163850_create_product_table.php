<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m150414_163850_create_product_table
 */
class m150414_163850_create_product_table extends Migration
{
    /**
     * migrate
     */
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => Schema::TYPE_PK,
            'cat_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'brand_id' => Schema::TYPE_INTEGER,
            'price' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
            'discount' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'stock' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'visible' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'order' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'image_url' => Schema::TYPE_STRING . " NOT NULL DEFAULT '/images/320x150.gif'",
            'rating' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "0/0"',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);

        $this->createTable('product_lang', [
            'id' => Schema::TYPE_PK,
            'product_id' => Schema::TYPE_INTEGER,
            'language' => Schema::TYPE_STRING . " NOT NULL DEFAULT 'en-US'",
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'subtitle' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'FULLTEXT KEY `name` (`name`,`subtitle`,`description`)'
        ]);

        $this->addForeignKey('product_lang_to_product', 'product_lang', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');

        $this->insert('product', [
            'id' => 1,
            'cat_id' => 1,
        ]);
        $this->insert('product_lang', [
            'product_id' => 1,
            'name' => 'Product',
            'description' => 'Product Description',
        ]);

        $this->insert('product', [
            'id' => 2,
            'cat_id' => 1,
        ]);
        $this->insert('product_lang', [
            'product_id' => 2,
            'name' => 'Product 2',
            'description' => 'Product Description',
        ]);

        $this->insert('product', [
            'id' => 3,
            'cat_id' => 1,
        ]);
        $this->insert('product_lang', [
            'product_id' => 3,
            'name' => 'Product 3',
            'description' => 'Product Description',
        ]);

    }

    /**
     * migrate/down
     */
    public function safeDown()
    {
        $this->dropForeignKey('product_lang_to_product', 'product_lang');
        $this->dropTable('product_lang');
        $this->dropTable('product');
    }

}
