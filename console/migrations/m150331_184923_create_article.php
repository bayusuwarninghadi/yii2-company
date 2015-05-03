<?php

use yii\db\Migration;
use yii\db\Schema;
use common\models\Article;

/**
 * Class m150331_184923_create_article
 */
class m150331_184923_create_article extends Migration
{
    /**
     * Migrate
     */
    public function safeUp()
    {
        $this->createTable('article', [
            'id' => Schema::TYPE_PK,
            'camel_case' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'order' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 3',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);

        $this->createTable('article_lang', [
            'id' => Schema::TYPE_PK,
            'article_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'language' => Schema::TYPE_TEXT,
        ]);

        /**
         * Static Pages
         * Using by default configuration
         */
        $this->insert('article', [
            'id' => 1,
            'camel_case' => 'Index',
        ]);
        $this->insert('article_lang', [
            'title' => 'index',
            'description' => 'index page',
            'language' => 'en-US',
            'article_id' => 1
        ]);

        $this->insert('article', [
            'id' => 2,
            'camel_case' => 'About',
        ]);
        $this->insert('article_lang', [
            'title' => 'about',
            'description' => 'about page',
            'language' => 'en-US',
            'article_id' => 2
        ]);

        $this->insert('article', [
            'id' => 3,
            'camel_case' => 'Faq',
        ]);
        $this->insert('article_lang', [
            'title' => 'faq',
            'description' => 'Frequently asked question',
            'language' => 'en-US',
            'article_id' => 3
        ]);

        $this->insert('article', [
            'id' => 4,
            'camel_case' => 'Privacy',
        ]);
        $this->insert('article_lang', [
            'title' => 'privacy',
            'description' => 'Privacy and Policy',
            'language' => 'en-US',
            'article_id' => 4
        ]);

        $this->insert('article', [
            'id' => 5,
            'camel_case' => 'Terms',
        ]);
        $this->insert('article_lang', [
            'title' => 'terms',
            'description' => 'Terms and Condition',
            'language' => 'en-US',
            'article_id' => 5
        ]);

        $this->insert('article', [
            'id' => 6,
            'camel_case' => 'Checkout',
        ]);
        $this->insert('article_lang', [
            'title' => 'checkout',
            'description' => 'This is note for checkout process',
            'language' => 'en-US',
            'article_id' => 6
        ]);

        $this->insert('article', [
            'id' => 7,
            'camel_case' => 'Success',
        ]);
        $this->insert('article_lang', [
            'title' => 'success',
            'description' => 'Thanks, check your email, we will delivery your order shortly',
            'language' => 'en-US',
            'article_id' => 7
        ]);

        $this->insert('article', [
            'id' => 8,
            'camel_case' => 'Confirmation',
        ]);
        $this->insert('article_lang', [
            'title' => 'confirmation',
            'description' => 'Confirmation Page',
            'language' => 'en-US',
            'article_id' => 8
        ]);

        /**
         * Slider Pages
         */
        $this->insert('article', [
            'id' => 9,
            'type_id' => Article::TYPE_SLIDER,
            'camel_case' => 'Slider',
        ]);
        $this->insert('article_lang', [
            'title' => 'slider',
            'description' => 'about page',
            'language' => 'en-US',
            'article_id' => 9
        ]);

        $this->insert('article', [
            'id' => 10,
            'type_id' => Article::TYPE_SLIDER,
            'camel_case' => 'Slider',
        ]);
        $this->insert('article_lang', [
            'title' => 'slider',
            'description' => 'about page',
            'language' => 'en-US',
            'article_id' => 10
        ]);

        /**
         * Article Pages
         */
        $this->insert('article', [
            'id' => 11,
            'type_id' => Article::TYPE_ARTICLE,
            'camel_case' => 'Article',
        ]);
        $this->insert('article_lang', [
            'title' => 'Article',
            'description' => 'Article Example',
            'language' => 'en-US',
            'article_id' => 11
        ]);

        $this->insert('article', [
            'id' => 12,
            'type_id' => Article::TYPE_ARTICLE,
            'camel_case' => 'Article2',
        ]);
        $this->insert('article_lang', [
            'title' => 'Article 2',
            'description' => 'Article Example',
            'language' => 'en-US',
            'article_id' => 12
        ]);

        /**
         * News Pages
         */
        $this->insert('article', [
            'id' => 13,
            'type_id' => Article::TYPE_NEWS,
            'camel_case' => 'News',
        ]);
        $this->insert('article_lang', [
            'title' => 'News',
            'description' => 'News Example',
            'language' => 'en-US',
            'article_id' => 13
        ]);

        $this->insert('article', [
            'id' => 14,
            'type_id' => Article::TYPE_NEWS,
            'camel_case' => 'News2',
        ]);
        $this->insert('article_lang', [
            'title' => 'News 2',
            'description' => 'News Example',
            'language' => 'en-US',
            'article_id' => 14
        ]);

    }

    /**
     * Migrate Down
     */
    public function safeDown()
    {
        $this->dropTable('article');
    }
}
