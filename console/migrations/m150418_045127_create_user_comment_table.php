<?php

use yii\db\Migration;
use yii\db\Schema;

class m150418_045127_create_user_comment_table extends Migration
{
    public function up()
    {
        $this->createTable('user_comment', [
            'id' => Schema::TYPE_PK,
            'table_key' => Schema::TYPE_STRING,
            'table_id' => Schema::TYPE_INTEGER,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'comment' => Schema::TYPE_TEXT,
            'rating' => Schema::TYPE_SMALLINT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey('user_comment_to_user', 'user_comment', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('user_comment_to_user', 'user_comment');
        $this->dropTable('user_comment');
    }
}
