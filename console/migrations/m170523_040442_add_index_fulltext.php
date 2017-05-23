<?php

use yii\db\Migration;

class m170523_040442_add_index_fulltext extends Migration
{
    public function up()
    {
		$this->execute('ALTER TABLE pages_lang ADD FULLTEXT(title)');
		$this->execute('ALTER TABLE pages_lang ADD FULLTEXT(subtitle)');
		$this->execute('ALTER TABLE pages_lang ADD FULLTEXT(description)');
    }

    public function down()
    {
    }
}
