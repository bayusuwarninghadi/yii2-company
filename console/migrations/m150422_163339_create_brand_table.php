<?php

use yii\db\Schema;
use yii\db\Migration;

class m150422_163339_create_brand_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('brand',[
            'id' => Schema::TYPE_PK,
            'brand' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT
        ]);
        $this->addForeignKey('product_to_brand','product','brand_id','brand','id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('product_to_brand','product');
        $this->dropTable('brand');
    }
}
