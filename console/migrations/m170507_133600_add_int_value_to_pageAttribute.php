<?php

use yii\db\Migration;

class m170507_133600_add_int_value_to_pageAttribute extends Migration
{
    public function up()
    {
		$this->addColumn(\common\models\PageAttribute::tableName(), 'int_value', $this->integer());
    }

    public function down()
    {
    }
}
