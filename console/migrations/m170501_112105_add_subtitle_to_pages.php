<?php

use yii\db\Migration;
use yii\db\Schema;

class m170501_112105_add_subtitle_to_pages extends Migration
{
    public function up()
    {
		$this->addColumn('pages', 'subtitle', Schema::TYPE_STRING);
		$this->addColumn('pages_lang', 'subtitle', Schema::TYPE_STRING);
    }

    public function down()
    {

    }
}
