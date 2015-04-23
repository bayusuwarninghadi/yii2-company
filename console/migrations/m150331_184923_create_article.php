<?php

use yii\db\Migration;
use yii\db\Schema;

class m150331_184923_create_article extends Migration
{
    public function safeUp()
    {
        $this->createTable('article', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'order' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 3',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);
        /*
         * Static Pages
         * Using by default configuration
         */
        $this->insert('article', [
            'title' => 'index',
            'description' => 'index page',
        ]);
        $this->insert('article', [
            'title' => 'about',
            'description' => 'about page',
        ]);
        $this->insert('article', [
            'title' => 'faq',
            'description' => 'Frequently asked question',
        ]);
        $this->insert('article', [
            'title' => 'privacy',
            'description' => 'Privacy and Policy',
        ]);
        $this->insert('article', [
            'title' => 'terms',
            'description' => 'Terms and Condition',
        ]);
        $this->insert('article', [
            'title' => 'checkout',
            'description' => 'This is note for checkout process',
        ]);
        $this->insert('article', [
            'title' => 'success',
            'description' => 'Thanks, check your email, we will delivery your order shortly',
        ]);
        $this->insert('article', [
            'title' => 'confirmation',
            'description' => 'Confirmation Page',
        ]);

        /*
        * Slider Pages
        */
        $this->insert('article', [
            'title' => 'slider',
            'description' => 'about page',
            'type_id' => 4,
        ]);
        $this->insert('article', [
            'title' => 'slider',
            'description' => 'about page',
            'type_id' => 4,
        ]);

        /*
        * Article Pages
        */
        $this->insert('article', [
            'title' => 'Article',
            'description' => 'Article Example',
            'type_id' => 1,
        ]);
        $this->insert('article', [
            'title' => 'Article 2',
            'description' => 'Article Example',
            'type_id' => 1,
        ]);

        /*
        * News Pages
        */
        $this->insert('article', [
            'title' => 'News',
            'description' => 'News Example',
            'type_id' => 2,
        ]);
        $this->insert('article', [
            'title' => 'News 2',
            'description' => 'News Example',
            'type_id' => 2,
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('article');
    }
}
