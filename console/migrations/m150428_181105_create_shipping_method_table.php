<?php

use yii\db\Migration;
use yii\db\Schema;

class m150428_181105_create_shipping_method_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('province', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->createTable('city', [
            'id' => Schema::TYPE_PK,
            'province_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->createTable('city_area', [
            'id' => Schema::TYPE_PK,
            'city_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->createTable('shipping_method', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
        ]);
        $this->createTable('shipping_method_cost', [
            'id' => Schema::TYPE_PK,
            'shipping_method_id' => Schema::TYPE_INTEGER,
            'value' => Schema::TYPE_BIGINT,
            'estimate_time' => Schema::TYPE_STRING,
            'city_area_id' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('city_area_to_city', 'city_area', 'city_id', 'city', 'id');
        $this->addForeignKey('city_to_province', 'city', 'province_id', 'province', 'id');
        $this->addForeignKey('shipping_method_cost_to_shipping_method', 'shipping_method_cost', 'shipping_method_id', 'shipping_method', 'id');
        $this->addForeignKey('shipping_method_cost_to_city_area', 'shipping_method_cost', 'city_area_id', 'city_area', 'id');

        $this->addForeignKey('shipping_to_city_area', 'shipping', 'city_area_id', 'city_area', 'id');
        $this->addForeignKey('transaction_to_shipping_method', 'transaction', 'shipping_method_id', 'shipping_method', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('shipping_to_city_area', 'shipping');
        $this->dropForeignKey('transaction_to_shipping_method', 'transaction');
        $this->dropForeignKey('city_area_to_city', 'city_area');
        $this->dropForeignKey('city_to_province', 'city');
        $this->dropForeignKey('shipping_method_cost_to_shipping_method', 'shipping_method_cost');
        $this->dropForeignKey('shipping_method_cost_to_city_area', 'shipping_method_cost');
        $this->dropTable('shipping_method_cost');
        $this->dropTable('shipping_method');
        $this->dropTable('city_area');
        $this->dropTable('city');
        $this->dropTable('province');
    }

}
