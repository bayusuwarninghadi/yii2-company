<?php

use common\models\Pages;
use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m150331_184923_create_article
 */
class m150331_184923_create_pages_table extends Migration
{
    /**
     * Migrate
     */
    public function safeUp()
    {
        $this->createTable('pages', [
            'id' => Schema::TYPE_PK,
            'cat_id' => Schema::TYPE_INTEGER,
            'camel_case' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'order' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 3',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_by' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
        ]);

        $this->createTable('pages_lang', [
            'id' => Schema::TYPE_PK,
            'page_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'language' => Schema::TYPE_STRING . " NOT NULL DEFAULT 'en-US'",
        ]);

        $this->addForeignKey('pages_lang_to_pages', 'pages_lang', 'page_id', 'pages', 'id', 'CASCADE', 'CASCADE');

        /**
         * Static Pages
         * Using by default configuration
         */
        $this->insert('pages', [
            'id' => 1,
            'camel_case' => 'Index',
        ]);
        $this->insert('pages_lang', [
            'title' => 'index',
            'description' => 'index page',
            'page_id' => 1
        ]);

        $this->insert('pages', [
            'id' => 2,
            'camel_case' => 'About',
        ]);
        $this->insert('pages_lang', [
            'title' => 'about',
            'description' => 'about page',
            'page_id' => 2
        ]);

        $this->insert('pages', [
            'id' => 3,
            'camel_case' => 'Faq',
        ]);
        $this->insert('pages_lang', [
            'title' => 'faq',
            'description' => 'Frequently asked question',
            'page_id' => 3
        ]);

        $this->insert('pages', [
            'id' => 4,
            'camel_case' => 'Privacy',
        ]);
        $this->insert('pages_lang', [
            'title' => 'privacy',
            'description' => 'Privacy and Policy',
            'page_id' => 4
        ]);

        $this->insert('pages', [
            'id' => 5,
            'camel_case' => 'Terms',
        ]);
        $this->insert('pages_lang', [
            'title' => 'terms',
            'description' => 'Terms and Condition',
            'page_id' => 5
        ]);

        $this->insert('pages', [
            'id' => 6,
            'camel_case' => 'Checkout',
        ]);
        $this->insert('pages_lang', [
            'title' => 'checkout',
            'description' => 'This is note for checkout process',
            'page_id' => 6
        ]);

        $this->insert('pages', [
            'id' => 7,
            'camel_case' => 'Success',
        ]);
        $this->insert('pages_lang', [
            'title' => 'success',
            'description' => 'Thanks, check your email, we will delivery your order shortly',
            'page_id' => 7
        ]);

        $this->insert('pages', [
            'id' => 8,
            'camel_case' => 'Confirmation',
        ]);
        $this->insert('pages_lang', [
            'title' => 'confirmation',
            'description' => 'Confirmation Page',
            'page_id' => 8
        ]);

        /**
         * Slider Pages
         */
        $this->insert('pages', [
            'id' => 9,
            'type_id' => Pages::TYPE_SLIDER,
            'camel_case' => 'Slider',
        ]);
        $this->insert('pages_lang', [
            'title' => 'slider',
            'description' => 'about page',
            'page_id' => 9
        ]);

        $this->insert('pages', [
            'id' => 10,
            'type_id' => Pages::TYPE_SLIDER,
            'camel_case' => 'Slider',
        ]);
        $this->insert('pages_lang', [
            'title' => 'slider',
            'description' => 'about page',
            'page_id' => 10
        ]);

        /**
         * Article Pages
         */
        $this->insert('pages', [
            'id' => 11,
            'type_id' => Pages::TYPE_PRODUCT,
            'camel_case' => 'Article',
        ]);
        $this->insert('pages_lang', [
            'title' => 'Article',
            'description' => 'Pages Example',
            'page_id' => 11
        ]);

        $this->insert('pages', [
            'id' => 12,
            'type_id' => Pages::TYPE_PRODUCT,
            'camel_case' => 'Article2',
        ]);
        $this->insert('pages_lang', [
            'title' => 'Pages 2',
            'description' => 'Pages Example',
            'page_id' => 12
        ]);

        /**
         * News Pages
         */
        $this->insert('pages', [
            'id' => 13,
            'type_id' => Pages::TYPE_NEWS,
            'camel_case' => 'News',
        ]);
        $this->insert('pages_lang', [
            'title' => 'News',
            'description' => 'News Example',
            'page_id' => 13
        ]);

        $this->insert('pages', [
            'id' => 14,
            'type_id' => Pages::TYPE_NEWS,
            'camel_case' => 'News2',
        ]);
        $this->insert('pages_lang', [
            'title' => 'News 2',
            'description' => 'News Example',
            'page_id' => 14
        ]);

    }

    /**
     * Migrate Down
     */
    public function safeDown()
    {
        $this->dropForeignKey('pages_lang_to_pages', 'pages_lang');
        $this->dropTable('pages_lang');
        $this->dropTable('pages');
    }
}
