<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'role' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 3',
            'image_url' => Schema::TYPE_STRING . " NOT NULL DEFAULT '/images/320x150.gif'",
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ], $tableOptions);
        $this->insert('user', [
            'username' => 'superadmin',
            'email' => 'superadmin@admin.com',
            'auth_key' => '1MV-hXk_2vGASsF_plu6s6vRQ5-S1ouI',
            'password_hash' => '$2y$13$umzEoJJig6qhp2oWtxsKO.1vn7oQo2evtQTNu4m878kCUMhyT6y0u',
            'role' => 1
        ]);
        $this->insert('user', [
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'auth_key' => '2MV-hXk_2vGASsF_plu6s6vRQ5-S1ouI',
            'password_hash' => '$2y$13$umzEoJJig6qhp2oWtxsKO.1vn7oQo2evtQTNu4m878kCUMhyT6y0u',
            'role' => 2
        ]);
        $this->insert('user', [
            'username' => 'user',
            'email' => 'user@user.com',
            'auth_key' => '3MV-hXk_2vGASsF_plu6s6vRQ5-S1ouI',
            'password_hash' => '$2y$13$umzEoJJig6qhp2oWtxsKO.1vn7oQo2evtQTNu4m878kCUMhyT6y0u',
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
